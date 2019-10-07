/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

(function () {
  const config = CKEDITOR.config;
  config.extraAllowedContent = 'div(*);picture';
  // Define changes to default configuration here.
  // For complete reference see:
  // http://docs.ckeditor.com/#!/api/CKEDITOR.config

  // The toolbar groups arrangement, optimized for two toolbar rows.
  config.toolbarGroups = [
    {name: 'clipboard', groups: ['clipboard', 'undo']},
    {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
    {name: 'links'},
    {name: 'insert'},
    {name: 'forms'},
    {name: 'tools'},
    {name: 'document', groups: ['mode', 'document', 'doctools']},
    {name: 'others'},
    {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
    {name: 'styles'},
    {name: 'colors'},
    {name: 'about'},
    {name: 'insert', items: ['BootstrapBuilder', 'Source']}
  ];

  // Remove some buttons provided by the standard plugins, which are
  // not needed in the Standard(s) toolbar.
  // config.removeButtons = 'Subscript,Superscript';

  // Set the most common block elements.
  config.format_tags = 'p;h1;h2;h3;pre;picture';

  // Simplify the dialog windows.
  config.removeDialogTabs = 'image:advanced;link:advanced';
  config.removeFormatTags = 'picture';

  config.bodyClass = 'xmlblock';
  config.removeButtons = 'Underline,BootstrapBuilder,spellchecker,Scayt';
  config.removePlugins = 'wsc,scayt';
  // setTimeout(function () {
  //   $('.cke_contents').css('height', '300px');
  // }, 1000);

  // If contentsCss is not an array, we make it array
  if (typeof config.contentsCss !== 'object') {
    if (config.contentsCss) {
      config.contentsCss = [config.contentsCss]
    }
  }

  config.contentsCss.push(FRONTEND_HOST + '/bundle/ckeditor.css');
  // If customConfig is not an array, we make it array
  if (typeof config.customConfig !== 'object') {
    if (config.customConfig) {
      config.customConfig = [config.customConfig];
    }
  }

  // bootstrapBuilder config
  config.extraPlugins = 'justify,bootstrapBuilder,youtube,blockquote,codemirror,colorbutton,colordialog,font';
  config.removePlugins = 'imageresponsive';

  config.colorButton_enableMore = true;
  config.colorButton_enableAutomatic = false;

  config.contentsCss.push('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
  config.mj_variables_bootstrap_css_path = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
  config.mj_variables_bootstrap_js_path = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';
  config.allowedContent = true;
  config.bootstrapBuilder_container_large_desktop = 1170;
  config.bootstrapBuilder_container_desktop = 970;
  config.bootstrapBuilder_container_tablet = 750;
  config.bootstrapBuilder_grid_columns = 12;
  config.bootstrapBuilder_ckfinder_version = 3;
  config.bootstrapBuilder_ckfinder_path = '/ckeditor/ckfinder3/ckfinder.js';
  config.filebrowserBrowseUrl = '/core/file/manager/ckeditor';
  config.filebrowserBrowseImageUrl = '/core/file/manager/ckeditor?filter=image';
  config.pictureTagImageCount = 8;
  config.image_prefillDimensions = false;
  config.codemirror = {

    // Whether or not you want Brackets to automatically close themselves
    autoCloseBrackets: true,

    // Whether or not you want tags to automatically close themselves
    autoCloseTags: true,

    // Whether or not to automatically format code should be done when the editor is loaded
    autoFormatOnStart: true,

    // Whether or not to automatically format code which has just been uncommented
    autoFormatOnUncomment: true,

    // Whether or not to continue a comment when you press Enter inside a comment block
    continueComments: true,

    // Whether or not you wish to enable code folding (requires 'lineNumbers' to be set to 'true')
    enableCodeFolding: true,

    // Whether or not to enable code formatting
    enableCodeFormatting: true,

    // Whether or not to enable search tools, CTRL+F (Find), CTRL+SHIFT+F (Replace), CTRL+SHIFT+R (Replace All), CTRL+G (Find Next), CTRL+SHIFT+G (Find Previous)
    enableSearchTools: true,

    // Whether or not to highlight all matches of current word/selection
    highlightMatches: true,

    // Whether, when indenting, the first N*tabSize spaces should be replaced by N tabs
    indentWithTabs: false,

    // Whether or not you want to show line numbers
    lineNumbers: true,

    // Whether or not you want to use line wrapping
    lineWrapping: true,

    // Define the language specific mode 'htmlmixed' for html  including (css, xml, javascript), 'application/x-httpd-php' for php mode including html, or 'text/javascript' for using java script only
    mode: 'htmlmixed',

    // Whether or not you want to highlight matching braces
    matchBrackets: true,

    // Whether or not you want to highlight matching tags
    matchTags: true,

    // Whether or not to show the showAutoCompleteButton   button on the toolbar
    showAutoCompleteButton: false,

    // Whether or not to show the comment button on the toolbar
    showCommentButton: false,

    // Whether or not to show the format button on the toolbar
    showFormatButton: false,

    // Whether or not to show the search Code button on the toolbar
    showSearchButton: false,

    // Whether or not to show Trailing Spaces
    showTrailingSpace: true,

    // Whether or not to show the uncomment button on the toolbar
    showUncommentButton: false,

    // Whether or not to highlight the currently active line
    styleActiveLine: true,

    // Set this to the theme you wish to use (codemirror themes)
    theme: 'default',

    // "Whether or not to use Beautify for auto formatting On start
    useBeautifyOnStart: false
  };
})();
