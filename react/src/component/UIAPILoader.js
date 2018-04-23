import APILoader from './APILoader';

export default class UIAPILoader extends APILoader {

  constructor(key) {
    super(key);
    this.config.v = '1.0.10';
    this.config.hostAndPath = 'webapi.amap.com/ui/1.0/main.js';
  }

  getScriptSrc(cfg) {
    const protocol = window.location.protocol;
    let scriptSrc = `${protocol}//${cfg.hostAndPath}?v=${cfg.v}&key=${cfg.key}`;
    if (cfg.plugin.length) scriptSrc += `&plugin=${cfg.plugin.join(',')}`;
    return scriptSrc;
  }

}
