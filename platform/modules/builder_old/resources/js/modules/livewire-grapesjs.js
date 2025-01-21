import { SokeioPlugin } from "../core/plugin";

export class LiveWireGrapesJSModule extends SokeioPlugin {
  getKey() {
    return "SOKEIO_LIVEWIRE_GRAPESJS_MODULE";
  }
  booting() {
    if (window.Livewire) {
      let self = this;
      let manager = self.getManager();
      const removeDivBuilderComponentPlus = (text) => {
        // Tạo một phần tử tạm thời để chứa chuỗi văn bản
        var tempElement = document.createElement("div");
        tempElement.innerHTML = text;

        // Lấy phần tử có class "div-builder-component-plus"
        var element = tempElement.querySelector(".div-builder-component-plus");

        // Kiểm tra xem phần tử có tồn tại không và loại bỏ nếu có
        if (element) {
          element.parentNode.removeChild(element);
        }
        tempElement.innerHTML = tempElement.innerHTML.replace(
          /<span class="shortcode-highlight">(.*?)<\/span>/g,
          "$1"
        );
        return tempElement.innerHTML;
      };
      window.Livewire.directive("grapesjs", ({ el, directive, component }) => {
        // Only fire this handler on the "root" directive.
        if (directive.modifiers.length > 0 || el.livewire____grapesjs) {
          return;
        }
        let options = {};
        if (el.hasAttribute("wire:grapesjs.options")) {
          options = new Function(
            `return ${el.getAttribute("wire:grapesjs.options")};`
          )();
        }
        const pluginManager = options.pluginManager ?? [];
        if (options?.pluginManager) {
          options = { ...options, pluginManager: undefined };
        }
        const highlightShortcodes = (content) => {
          var openingTag = '<span class="shortcode-highlight">';
          var closingTag = "</span>";
          var highlightedContent = content.replace(
            /\[(\/?[^\]]+)\]/g,
            function (match, shortcode) {
              if (shortcode.startsWith("/")) {
                return "[" + shortcode + "]" + closingTag;
              } else if (shortcode.endsWith("/")) {
                return openingTag + "[" + shortcode + "]" + closingTag;
              } else {
                return openingTag + "[" + shortcode + "]";
              }
            }
          );

          return highlightedContent;
        };
        const grapesjsCreate = () => {
          if (!el.livewire____grapesjs) {
            el.livewire____grapesjs = grapesjs.init({
              // Indicate where to init the editor. You can also pass an HTMLElement
              container: el,
              storageManager: false,
              style: manager.dataGet(component.$wire, "data.css"),
              // HTML string or a JSON of components
              components: manager.dataGet(component.$wire, "data.content"),
              ...options,
              plugins: pluginManager.map(function (item) {
                return item.name;
              }),
              pluginsOpts: pluginManager.reduce(function (previous, current) {
                previous[current.name] = current.options ?? {};
                return previous;
              }, {}),
              pages: false,
              assetManager: {
                // ...
                custom: {
                  open(props) {
                    window.showFileManager(function (file) {
                      console.log(file[0]["url"]);
                      props.select(file[0]["url"]);
                      props.close();
                    });
                  },
                  close(props) {
                    // Close the external Asset Manager
                  },
                },
              },
            });
            el.livewire____grapesjs.Commands.add("sokeio-builder-save-data", {
              run: async function (editor, sender) {
                sender && sender.set("active", 0); // turn off the button
                component.$wire.doSave();
              },
            });
            el.livewire____grapesjs.on("change", function () {
              manager.dataSet(
                component.$wire,
                "data.css",
                el.livewire____grapesjs.getCss()
              );
              manager.dataSet(
                component.$wire,
                "data.content",
                removeDivBuilderComponentPlus(el.livewire____grapesjs.getHtml())
              );
              manager.dataSet(
                component.$wire,
                "data.js",
                el.livewire____grapesjs.getJs()
              );
            });
            el.livewire____grapesjs.on("load", function () {
              const content = highlightShortcodes(
                manager.dataGet(component.$wire, "data.content")
              );
              // document.querySelector('.sokeio-builder-header__right').innerHTML='';
              el.livewire____grapesjs.setComponents(content);
              // el.livewire____grapesjs.render();
              // console.log(el.livewire____grapesjs);
              // const deviceManager = el.livewire____grapesjs.DeviceManager;
              // const deviceManagerContainer = document.querySelector(
              //   ".sokeio-builder-manager .device-manager"
              // );
              // deviceManagerContainer.appendChild(deviceManager.render());
            });
            el.livewire____grapesjs.on("stop:preview", () => {
              // Xử lý khi sự kiện design xảy ra
              el.closest(".sokeio-builder-manager").classList.remove(
                "sokeio-builder-preview"
              );
            });
            el.livewire____grapesjs.on("run:preview", () => {
              // Xử lý khi sự kiện design xảy ra
              el.closest(".sokeio-builder-manager").classList.add(
                "sokeio-builder-preview"
              );
            });
          }
        };
        if (window.grapesjs) {
          grapesjsCreate();
        } else {
          window.SokeioLoadStyle(
            "https://cdn.jsdelivr.net/npm/grapesjs@0.21.6/dist/css/grapes.min.css",
            ...pluginManager.reduce(function (previous, current) {
              return [...previous, ...(current.css ?? [])];
            }, [])
          );
          window
            .SokeioLoadScript([
              "https://cdn.jsdelivr.net/npm/grapesjs@0.21.6/dist/grapes.min.js",
              ...pluginManager.reduce(function (previous, current) {
                return [...previous, ...(current.js ?? [])];
              }, []),
            ])
            .then(function () {
              grapesjsCreate();
            });
        }
      });
    }
  }
}
