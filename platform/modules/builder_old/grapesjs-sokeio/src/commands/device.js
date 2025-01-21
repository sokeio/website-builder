import {
  cmdDeviceDesktop,
  cmdDeviceTablet,
  cmdDeviceMobile,
  cmdClear,
} from "./../consts";

export default (editor, opts = {}) => {
  const Commands = editor.Commands;
  const txtConfirm = opts.textCleanCanvas;
  Commands.add(cmdDeviceDesktop, {
    run: (ed) => ed.setDevice("Desktop"),
    stop: () => {},
  });
  Commands.add(cmdDeviceTablet, {
    run: (ed) => ed.setDevice("Tablet"),
    stop: () => {},
  });
  Commands.add(cmdDeviceMobile, {
    run: (ed) => ed.setDevice("Mobile portrait"),
    stop: () => {},
  });
  Commands.add(
    cmdClear,
    (e) => confirm(txtConfirm) && e.runCommand("core:canvas-clear")
  );
};
