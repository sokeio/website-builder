export default (editor, opts = {}) => {
  const command = editor.Commands;
  const openDialog = function (editor, sender, model) {
    let callback = "eventAddComponent" + new Date().getTime();

    let modal = window.SokeioManager.openModal(
      {
        $url: opts.urlTemplateManager,
        $title: opts.titleTemplateManager,
        $size: "modal-xl modal-fullscreen-lg-down",
      },
      { callbackEvent: callback }
    );
    window[callback] = function (template) {
      var newComponent = editor.DomComponents.addComponent(template);
      // Append the new component as a child of the selected component
      modal.hide();
      model.components().add(newComponent);
      model.trigger("change:content");
      editor.trigger("component:update");
      // model.trigger("change");
      // Render the changes
      model.view.render();
      // Render the changes
      // editor.render();
    };
  };
  command.add("open-template-dialog", {
    run: function (editor, sender, model) {
      openDialog(editor, sender, model);
    },
  });
};
