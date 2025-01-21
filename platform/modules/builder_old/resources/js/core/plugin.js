export class SokeioPlugin {
  _manager;
  getKey() {
    return "";
  }
  manager(manager) {
    this._manager = manager;
  }
  getManager() {
    return this._manager;
  }
  register() {}
  booting() {}
  booted() {}
  dispose() {}
}
