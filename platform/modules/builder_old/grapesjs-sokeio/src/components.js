import { regexShortcode } from "./consts";

export default (editor, opts = {}) => {
  const domc = editor.Components;
  const cm = editor.Commands;
  const pfx = editor.Config.stylePrefix;
  const { useRenderShortcode } = opts;
  // editor.on("run:preview", (data) => {
  //   console.log("run preview", isPreview(), data);
  //   document.querySelector(
  //     ".sokeio-builder-header__right .options-panel-manager"
  //   ).innerHTML = "";
  //   editor.stopCommand("sw-visibility");
  //   editor.render();
  //   setTimeout(() => {
  //     editor.getModel().stopDefault();
  //     const editorEl = editor.editorView.el;
  //     console.log({ editor });
  //     if (editorEl.querySelector(`${pfx}off-prv`)) return;
  //     const helper = document.createElement("span");
  //     helper.className = `${pfx}off-prv fa fa-eye-slash`;
  //     editorEl.appendChild(helper);
  //     helper.onclick = () => editor.stopCommand("preview");
  //   }, 100);
  // });
  // editor.on("stop:preview", () => {
  //   console.log(["stop preview", isPreview()]);
  //   editor.refres();
  // });
  domc.addType("shortcode", {
    isComponent: (el) =>
      // el.tagName === "DIV" &&
      el.childElementCount == 0 && regexShortcode.test(el.innerText),
    model: {
      defaults: {
        tagName: "",
        name: "shortcode",
        draggable: true,
        droppable: false,
        removed: false,
        content: '<div data-gjs-type="shortcode"></div>',
      },
    },

    view: {
      events: {
        click: "handleClick",
      },
      handleClick: function (e) {
        editor.runCommand("open-shortcode-dialog", this.model);
      },
      async onRender({ model }) {
        let html = this.el.innerHTML;
        if (!useRenderShortcode) return;
        if (regexShortcode.test(html) || regexShortcode.test(model.content)) {
          let $wireId = Alpine.closestRoot(
            editor.editorView.$el[0]
          )?.getAttribute("wire:id");
          if ($wireId) {
            let shortcode = this.el.innerHTML;
            if (regexShortcode.test(model.content)) {
              shortcode = model.content;
            }
            let content = await Livewire.find($wireId).ConvertShortcodeToHtml(
              shortcode
            );
            if (this.el.getAttribute("data-gjs-type") === "shortcode") {
              this.el.innerHTML = `${content}`;
              this.el.setAttribute("data-shortcode", encodeURIComponent(html));
            } else {
              this.el.innerHTML = `<div data-gjs-type="shortcode">${content}</div>`;
              this.el.setAttribute(
                "data-shortcode",
                encodeURIComponent(
                  '<div data-gjs-type="shortcode">' + html + "</div>"
                )
              );
            }
          }
        }
      },
    },
  });
  editor.on("component:styleUpdate", function (model) {
    if (model && model.get("type") === "shortcode") {
      // Áp dụng kiểu CSS cho thành phần block shortcode trong canvas
      model.set({
        style: {
          "min-height": "50px",
          padding: "20px",
          border: "1px dashed #ccc",
          "background-color": "rgba(0,0,0,0.1)",
          // Các thuộc tính style khác tùy ý
        },
      });
    }
  });
};
