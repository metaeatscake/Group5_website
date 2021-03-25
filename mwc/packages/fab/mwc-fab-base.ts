/**
 * @license
 * Copyright 2018 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
import '@material/mwc-ripple/mwc-ripple';

import {Ripple} from '@material/mwc-ripple/mwc-ripple';
import {RippleHandlers} from '@material/mwc-ripple/ripple-handlers';
import {eventOptions, html, internalProperty, LitElement, property, queryAsync, TemplateResult} from 'lit-element';
import {classMap} from 'lit-html/directives/class-map';

/**
 * Fab Base class logic and template definition
 * @soyCompatible
 */
export class FabBase extends LitElement {
  @queryAsync('mwc-ripple') ripple!: Promise<Ripple|null>;

  @property({type: Boolean}) mini = false;

  @property({type: Boolean}) exited = false;

  @property({type: Boolean}) disabled = false;

  @property({type: Boolean}) extended = false;

  @property({type: Boolean}) showIconAtEnd = false;

  @property({type: Boolean}) reducedTouchTarget = false;

  @property() icon = '';

  @property() label = '';

  @internalProperty() protected shouldRenderRipple = false;

  protected rippleHandlers = new RippleHandlers(() => {
    this.shouldRenderRipple = true;
    return this.ripple;
  });

  protected createRenderRoot() {
    return this.attachShadow({mode: 'open', delegatesFocus: true});
  }

  /**
   * @soyTemplate
   * @soyClasses fabClasses: .mdc-fab
   */
  protected render(): TemplateResult {
    const hasTouchTarget = this.mini && !this.reducedTouchTarget;
    /** @classMap */
    const classes = {
      'mdc-fab--mini': this.mini,
      'mdc-fab--touch': hasTouchTarget,
      'mdc-fab--exited': this.exited,
      'mdc-fab--extended': this.extended,
      'icon-end': this.showIconAtEnd,
    };

    const ariaLabel = this.label ? this.label : this.icon;

    return html`
      <button
          class="mdc-fab ${classMap(classes)}"
          ?disabled="${this.disabled}"
          aria-label="${ariaLabel}"
          @mouseenter=${this.handleRippleMouseEnter}
          @mouseleave=${this.handleRippleMouseLeave}
          @focus=${this.handleRippleFocus}
          @blur=${this.handleRippleBlur}
          @mousedown=${this.handleRippleActivate}
          @touchstart=${this.handleRippleStartPress}
          @touchend=${this.handleRippleDeactivate}
          @touchcancel=${this.handleRippleDeactivate}>
        ${this.renderBeforeRipple()}
        ${this.renderRipple()}
        ${this.showIconAtEnd ? this.renderLabel() : ''}
        <span class="icon-slot-container">
          <slot name="icon">
            ${this.renderIcon()}
          </slot>
        </span>
        ${!this.showIconAtEnd ? this.renderLabel() : ''}
        ${this.renderTouchTarget()}
      </button>`;
  }

  /** @soyTemplate */
  protected renderIcon(): TemplateResult {
    return html`${
        this.icon ? html`
          <span class="material-icons mdc-fab__icon">${this.icon}</span>` :
                    ''}`;
  }

  /** @soyTemplate */
  protected renderTouchTarget(): TemplateResult {
    const hasTouchTarget = this.mini && !this.reducedTouchTarget;

    return html`${
        hasTouchTarget ? html`<div class="mdc-fab__touch"></div>` : ''}`;
  }

  /** @soyTemplate */
  protected renderLabel(): TemplateResult {
    const showLabel = this.label !== '' && this.extended;

    return html`${
        showLabel ? html`<span class="mdc-fab__label">${this.label}</span>` :
                    ''}`;
  }

  /** @soyTemplate */
  protected renderBeforeRipple(): TemplateResult {
    return html``;
  }

  /** @soyTemplate */
  protected renderRipple(): TemplateResult|string {
    return this.shouldRenderRipple ?
        html`<mwc-ripple class="ripple"></mwc-ripple>` :
        '';
  }

  protected handleRippleActivate(event?: Event) {
    const onUp = () => {
      window.removeEventListener('mouseup', onUp);

      this.handleRippleDeactivate();
    };

    window.addEventListener('mouseup', onUp);
    this.handleRippleStartPress(event);
  }

  @eventOptions({passive: true})
  protected handleRippleStartPress(event?: Event) {
    this.rippleHandlers.startPress(event);
  }

  protected handleRippleDeactivate() {
    this.rippleHandlers.endPress();
  }

  protected handleRippleMouseEnter() {
    this.rippleHandlers.startHover();
  }

  protected handleRippleMouseLeave() {
    this.rippleHandlers.endHover();
  }

  protected handleRippleFocus() {
    this.rippleHandlers.startFocus();
  }

  protected handleRippleBlur() {
    this.rippleHandlers.endFocus();
  }
}
