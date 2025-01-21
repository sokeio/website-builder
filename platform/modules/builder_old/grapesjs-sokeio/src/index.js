import loadComponents from "./components";
import loadPanels from "./panels";
import loadCommands from "./commands";
import loadBlocks from "./blocks";
import en from "./locale/en";

export default (editor, opts = {}) => {
  const options = {
    ...{
      i18n: {},
      // default options
    },
    modalImportTitle: "Import",
    modalImportButton: "Import",
    modalImportLabel: "",
    modalImportContent: "",
    importViewerOptions: {},
    textCleanCanvas: "Are you sure you want to clear the canvas?",
    showStylesOnChange: true,
    useCustomTheme: true,
    titleTemplateManager: "Template Manager",
    urlTemplateManager: "",
    useRenderShortcode: false,
    ...opts,
  };
  // Add panels
  loadPanels(editor, options);
  // Add commands
  loadCommands(editor, options);
  // Add components
  loadComponents(editor, options);
  // Add blocks
  loadBlocks(editor, options);
  // Load i18n files
  editor.I18n &&
    editor.I18n.addMessages({
      en,
      ...options.i18n,
    });

  editor.on("component:selected", function (model) {
    const commandToAdd = "open-template-dialog";
    const commandIcon = "fa fa-clock";

    // get the selected componnet and its default toolbar
    const selectedComponent = editor.getSelected();
    const defaultToolbar = selectedComponent.get("toolbar");

    // check if this command already exists on this component toolbar
    const commandExists = defaultToolbar.some(
      (item) => item.command === commandToAdd
    );

    // if it doesn't already exist, add it
    if (!commandExists) {
      console.log(defaultToolbar);
      selectedComponent.set({
        toolbar: [
          {
            label:
              '<svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>',
            command: commandToAdd,
          },
          ...defaultToolbar,
        ],
      });
    }
  });

  editor.on("component:deselected", function (model) {
    model.view.el.querySelector(".div-builder-component-plus")?.remove();
  });
  editor.on("component:dblclick", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
    }
  });
  editor.on("block:drag:stop", function (model) {
    if (model && model.get("type") === "shortcode") {
      editor.runCommand("open-shortcode-dialog", model);
    }
  });
  // TODO Remove
  // editor.on('load', () =>
  //   editor.addComponents(
  //       `<div style="margin:100px; padding:25px;">
  //           Content loaded from the plugin
  //       </div>`,
  //       { at: 0 }
  //   ))
};
