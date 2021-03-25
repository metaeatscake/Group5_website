/**
@license
Copyright 2019 Google Inc. All Rights Reserved.

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
import {LitElement, html, css} from 'lit-element/lit-element.js';
import '@material/mwc-list';
import '@material/mwc-list/mwc-list-item';

class DemoView extends LitElement {
  static get styles() {
    return [
      css`
        header {
          background-color: #6200ee;
          position: fixed;
          top: 0;
          left: 0;
          z-index: 4;
          width: 100%;
          display: flex;
          align-items: center;
          padding: 8px 12px;
          box-sizing: border-box;
          font-family: "Roboto Mono", monospace;
          -webkit-font-smoothing: antialiased;
          font-size: 1.25rem;
          line-height: 2rem;
          letter-spacing: 0.02em;
          color: white;
          min-height: 64px;
          box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.2), 0px 4px 5px 0px rgba(0, 0, 0, 0.14), 0px 1px 10px 0px rgba(0, 0, 0, 0.12);
        }

        .demo-catalog-logo {
          height: 48px;
          width: 48px;
          display: inline-block;
          padding: 12px;
          display: flex;
          justify-content: center;
          box-sizing: border-box;
        }

        mwc-list {
          margin-top: 64px;
        }

        .demo-catalog-list-icon {
          margin: 0 24px 0 12px;
        }

        .demo-heading {
          margin-left: 8px;
        }

        mwc-list-item {
          --mdc-list-side-padding: 28px;
          --mdc-list-item-graphic-margin: 24px;
        }

        mwc-button {
          --mdc-theme-primary: white;
        }`,
    ];
  }

  constructor() {
    super();

    const sortFn = (first, second) => {
      const isEqual = first.name === second.name;

      if (isEqual) {
        return 0;
      }

      if (first.name < second.name) {
        return -1;
      } else {
        return 1;
      }
    };

    this.listItems = [
      {
        name: 'Elevation Overlay',
        secondary: 'Element overlays for dark mode elevation and emphasis',
        href: 'elevation-overlay/',
        img: 'https://fonts.gstatic.com/s/i/materialicons/flip_to_front/v6/24px.svg',
      },
      {
        name: 'Button',
        secondary: 'Raised and flat buttons',
        href: 'button/',
        img: 'https://material-components-web.appspot.com/images/ic_button_24px.svg',
      },
      {
        name: 'Floating action button',
        secondary: 'The primary action in an application',
        href: 'fab/',
        img: 'https://material-components-web.appspot.com/images/ic_button_24px.svg',
      },
      {
        name: 'Checkbox',
        secondary: 'Multi-selection controls',
        href: 'checkbox/',
        img: 'https://material-components-web.appspot.com/images/ic_selection_control_24px.svg',
      },
      {
        name: 'Circular Progress',
        secondary: 'Fills from 0-100%, represented by an arc.',
        href: 'circular-progress/',
        img: 'https://material-components-web.appspot.com/images/ic_progress_activity.svg',
      },
      {
        name: 'Drawer',
        secondary: 'Navigation to provide access to destinations.',
        href: 'drawer/',
        img: 'https://material-components-web.appspot.com/images/ic_component_24px.svg',
      },
      {
        name: 'Dialog',
        secondary: 'Popup that gains user attention.',
        href: 'dialog/',
        img: 'https://material-components-web.appspot.com/images/ic_dialog_24px.svg',
      },
      {
        name: 'Formfield',
        secondary: 'Layout form fields with labels',
        href: 'formfield/',
        img: 'https://material-components-web.appspot.com/images/ic_text_field_24px.svg',
      },
      {
        name: 'Icon',
        secondary: 'Material design icons',
        href: 'icon/',
        img: 'https://material-components-web.appspot.com/images/ic_component_24px.svg',
      },
      {
        name: 'Icon Button',
        secondary: 'Icon buttons allow users to take actions, and make choices, with a single tap.',
        href: 'icon-button/',
        img: 'https://material-components-web.appspot.com/images/ic_component_24px.svg',
      },
      {
        name: 'Icon Button Toggle',
        secondary: 'Toggling icon states',
        href: 'icon-button-toggle/',
        img: 'https://material-components-web.appspot.com/images/ic_component_24px.svg',
      },
      {
        name: 'Linear Progress',
        secondary: 'Fills from 0% to 100%, represented by bars',
        href: 'linear-progress/',
        img: 'https://material-components-web.appspot.com/images/ic_progress_activity.svg',
      },
      {
        name: 'List',
        secondary: 'Continuous, vertical indexes of text or images.',
        href: 'list/',
        img: 'https://fonts.gstatic.com/s/i/materialicons/view_list/v6/24px.svg',
      },
      {
        name: 'Menu',
        secondary: 'Displays a list of choices on a temporary surface.',
        href: 'menu/',
        img: 'https://fonts.gstatic.com/s/i/materialicons/picture_in_picture/v6/24px.svg',
      },
      {
        name: 'Radio buttons',
        secondary: 'Single selection controls',
        href: 'radio/',
        img: 'https://material-components-web.appspot.com/images/ic_radio_button_24px.svg',
      },
      {
        name: 'Ripple',
        secondary: 'Touch ripple',
        href: 'ripple/',
        img: 'https://material-components-web.appspot.com/images/ic_ripple_24px.svg',
      },
      {
        name: 'Select',
        secondary: 'Single option dropdown select menus',
        href: 'select/',
        img: 'https://fonts.gstatic.com/s/i/materialicons/list_alt/v6/24px.svg',
      },
      {
        name: 'Slider',
        secondary: 'Range controls',
        href: 'slider/',
        img: 'https://material-components-web.appspot.com/images/slider.svg',
      },
      {
        name: 'Snackbar',
        secondary: 'Transient messages',
        href: 'snackbar/',
        img: 'https://material-components-web.appspot.com/images/ic_toast_24px.svg',
      },
      {
        name: 'Switch',
        secondary: 'On off controls',
        href: 'switch/',
        img: 'https://material-components-web.appspot.com/images/ic_switch_24px.svg',
      },
      {
        name: 'Tabs',
        secondary: 'Tabs with support for icon and text labels',
        href: 'tabs/',
        img: 'https://material-components-web.appspot.com/images/ic_tabs_24px.svg',
      },
      {
        name: 'Textfield',
        secondary: 'Single line text input',
        href: 'textfield/',
        img: 'https://material-components-web.appspot.com/images/ic_text_field_24px.svg',
      },
      {
        name: 'Textarea',
        secondary: 'Multiline text input',
        href: 'textarea/',
        img: 'https://material-components-web.appspot.com/images/ic_text_field_24px.svg',
      },
      {
        name: 'Top App Bar',
        secondary: 'Container for items such as application title, navigation icon, and action items.',
        href: 'top-app-bar/',
        img: 'https://material-components-web.appspot.com/images/ic_toolbar_24px.svg',
      },
      {
        name: 'Top App Bar Fixed',
        secondary: 'Container for items such as application title, navigation icon, and action items.',
        href: 'top-app-bar-fixed/',
        img: 'https://material-components-web.appspot.com/images/ic_toolbar_24px.svg',
      },
    ].sort(sortFn);
  }


  render() {
    const listItems = this.listItems.map((item) => {
      return html`
        <mwc-list-item twoline graphic="icon" data-href=${item.href}>
          <span>${item.name}</span>
          <span slot="secondary">${item.secondary}</span>
          <img
              slot="graphic"
              alt="${item.name}
              icon" src=${item.img}
              aria-hidden="true">
        </mwc-list-item>`;
    });

    return html`
      <header>
        <span class="demo-catalog-logo">
          <img
              alt="Generic component icon"
              src="https://material-components-web.appspot.com/images/ic_component_24px_white.svg">
        </span>
        <span class="demo-heading">Material Web Components Catalog</span>
      </header>
      <div class="demo-list">
        <mwc-list wrapFocus innerRole="navigation" innerAriaLabel="Material Web Component Demos" itemRoles="link" rootTabbable @selected=${this.onSelected}>
          ${listItems}
        </mwc-list>
      </div>
    `;
  }

  onSelected(e) {
    const list = this.shadowRoot.querySelector('mwc-list');
    const index = e.detail.index;
    const item = list.items[index];
    const href = item.dataset.href;
    window.location.href = `${window.location.href}/../${href}`;
  }
}

customElements.define('demo-view', DemoView);
