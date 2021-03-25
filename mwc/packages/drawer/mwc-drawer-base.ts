/**
@license
Copyright 2018 Google Inc. All Rights Reserved.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

// Note this blocking-elements import is not redundant with the one below,
// because we need to ensure we import this module at runtime for its
// side-effects. See
// https://github.com/Microsoft/TypeScript/wiki/FAQ#why-are-imports-being-elided-in-my-emit.
import 'blocking-elements';
import 'wicg-inert';

import {MDCDrawerAdapter} from '@material/drawer/adapter';
import {strings} from '@material/drawer/constants';
import MDCDismissibleDrawerFoundation from '@material/drawer/dismissible/foundation';
import MDCModalDrawerFoundation from '@material/drawer/modal/foundation';
import {addHasRemoveClass, BaseElement} from '@material/mwc-base/base-element';
import {observer} from '@material/mwc-base/observer';
import {DocumentWithBlockingElements} from 'blocking-elements';
import {html, property, PropertyValues, query} from 'lit-element';
import {classMap} from 'lit-html/directives/class-map';

interface InertableHTMLElement extends HTMLElement {
  inert?: boolean;
}

const blockingElements =
    (document as DocumentWithBlockingElements).$blockingElements;

export class DrawerBase extends BaseElement {
  @query('.mdc-drawer') protected mdcRoot!: HTMLElement;

  @query('.mdc-drawer-app-content') protected appContent!: InertableHTMLElement;

  protected mdcFoundation!: MDCDismissibleDrawerFoundation;

  protected get mdcFoundationClass() {
    return this.type === 'modal' ? MDCModalDrawerFoundation :
                                   MDCDismissibleDrawerFoundation;
  }

  protected createAdapter(): MDCDrawerAdapter {
    return {
      ...addHasRemoveClass(this.mdcRoot),
      elementHasClass: (element: HTMLElement, className: string) =>
          element.classList.contains(className),
      saveFocus: () => {
        // Note, casting to avoid cumbersome runtime check.
        this._previousFocus =
            (this.getRootNode() as ShadowRoot).activeElement as HTMLElement;
      },
      restoreFocus: () => {
        const previousFocus = this._previousFocus && this._previousFocus.focus;
        if (previousFocus) {
          // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
          this._previousFocus!.focus();
        }
      },
      notifyClose: () => {
        this.open = false;
        this.dispatchEvent(
            new Event(strings.CLOSE_EVENT, {bubbles: true, cancelable: true}));
      },
      notifyOpen: () => {
        this.open = true;
        this.dispatchEvent(
            new Event(strings.OPEN_EVENT, {bubbles: true, cancelable: true}));
      },
      focusActiveNavigationItem:
          () => { /* TODO(sorvell): Implement list focusing integration. */ },
      trapFocus: () => {
        blockingElements.push(this);
        this.appContent.inert = true;
      },
      releaseFocus: () => {
        blockingElements.remove(this);
        this.appContent.inert = false;
      },
    };
  }

  private _previousFocus: HTMLElement|null = null;

  private _handleScrimClick() {
    if (this.mdcFoundation instanceof MDCModalDrawerFoundation) {
      this.mdcFoundation.handleScrimClick();
    }
  }

  @observer(function(this: DrawerBase, value: boolean) {
    if (this.type === '') {
      return;
    }
    if (value) {
      this.mdcFoundation.open();
    } else {
      this.mdcFoundation.close();
    }
  })
  @property({type: Boolean, reflect: true})
  open = false;

  @property({type: Boolean}) hasHeader = false;

  @property({reflect: true}) type = '';

  protected render() {
    const dismissible = this.type === 'dismissible' || this.type === 'modal';
    const modal = this.type === 'modal';
    const header = this.hasHeader ? html`
      <div class="mdc-drawer__header">
        <h3 class="mdc-drawer__title"><slot name="title"></slot></h3>
        <h6 class="mdc-drawer__subtitle"><slot name="subtitle"></slot></h6>
        <slot name="header"></slot>
      </div>
      ` :
                                    '';
    const classes = {
      'mdc-drawer--dismissible': dismissible,
      'mdc-drawer--modal': modal,
    };

    return html`
      <aside class="mdc-drawer ${classMap(classes)}">
        ${header}
        <div class="mdc-drawer__content"><slot></slot></div>
      </aside>
      ${
        modal ? html`<div class="mdc-drawer-scrim"
                          @click="${this._handleScrimClick}"></div>` :
                ''}
      <div class="mdc-drawer-app-content">
        <slot name="appContent"></slot>
      </div>
      `;
  }

  // note, we avoid calling `super.firstUpdated()` to control when
  // `createFoundation()` is called.
  protected firstUpdated() {
    this.mdcRoot.addEventListener(
        'keydown', (e) => this.mdcFoundation.handleKeydown(e));
    this.mdcRoot.addEventListener(
        'transitionend', (e) => this.mdcFoundation.handleTransitionEnd(e));
  }

  protected updated(changedProperties: PropertyValues) {
    if (changedProperties.has('type')) {
      this.createFoundation();
    }
  }
}
