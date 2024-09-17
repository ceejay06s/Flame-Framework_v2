(self.webpackChunk=self.webpackChunk||[]).push([[998],{998:(e,t,r)=>{const n=r(16),o=r(627),i=r(667),s=r(682),a=r(56).version,c=/(?:^|^)\s*(?:export\s+)?([\w.-]+)(?:\s*=\s*?|:\s+?)(\s*'(?:\\'|[^'])*'|\s*"(?:\\"|[^"])*"|\s*`(?:\\`|[^`])*`|[^#\r\n]+)?\s*(?:#.*)?(?:$|$)/gm;function u(e){console.log(`[dotenv@${a}][DEBUG] ${e}`)}function l(e){return e&&e.DOTENV_KEY&&e.DOTENV_KEY.length>0?e.DOTENV_KEY:"MISSING_ENV_VAR".DOTENV_KEY&&"MISSING_ENV_VAR".DOTENV_KEY.length>0?"MISSING_ENV_VAR".DOTENV_KEY:""}function p(e,t){let r;try{r=new URL(t)}catch(e){if("ERR_INVALID_URL"===e.code){const e=new Error("INVALID_DOTENV_KEY: Wrong format. Must be in valid uri format like dotenv://:key_1234@dotenvx.com/vault/.env.vault?environment=development");throw e.code="INVALID_DOTENV_KEY",e}throw e}const n=r.password;if(!n){const e=new Error("INVALID_DOTENV_KEY: Missing key part");throw e.code="INVALID_DOTENV_KEY",e}const o=r.searchParams.get("environment");if(!o){const e=new Error("INVALID_DOTENV_KEY: Missing environment part");throw e.code="INVALID_DOTENV_KEY",e}const i=`DOTENV_VAULT_${o.toUpperCase()}`,s=e.parsed[i];if(!s){const e=new Error(`NOT_FOUND_DOTENV_ENVIRONMENT: Cannot locate environment ${i} in your .env.vault file.`);throw e.code="NOT_FOUND_DOTENV_ENVIRONMENT",e}return{ciphertext:s,key:n}}function f(e){let t=null;if(e&&e.path&&e.path.length>0)if(Array.isArray(e.path))for(const r of e.path)n.existsSync(r)&&(t=r.endsWith(".vault")?r:`${r}.vault`);else t=e.path.endsWith(".vault")?e.path:`${e.path}.vault`;else t=o.resolve(process.cwd(),".env.vault");return n.existsSync(t)?t:null}function g(e){return"~"===e[0]?o.join(i.homedir(),e.slice(1)):e}const d={configDotenv:function(e){const t=o.resolve(process.cwd(),".env");let r="utf8";const i=Boolean(e&&e.debug);e&&e.encoding?r=e.encoding:i&&u("No encoding is specified. UTF-8 is used by default");let s,a=[t];if(e&&e.path)if(Array.isArray(e.path)){a=[];for(const t of e.path)a.push(g(t))}else a=[g(e.path)];const c={};for(const t of a)try{const o=d.parse(n.readFileSync(t,{encoding:r}));d.populate(c,o,e)}catch(e){i&&u(`Failed to load ${t} ${e.message}`),s=e}let l="MISSING_ENV_VAR";return e&&null!=e.processEnv&&(l=e.processEnv),d.populate(l,c,e),s?{parsed:c,error:s}:{parsed:c}},_configVault:function(e){console.log(`[dotenv@${a}][INFO] Loading env from encrypted .env.vault`);const t=d._parseVault(e);let r="MISSING_ENV_VAR";return e&&null!=e.processEnv&&(r=e.processEnv),d.populate(r,t,e),{parsed:t}},_parseVault:function(e){const t=f(e),r=d.configDotenv({path:t});if(!r.parsed){const e=new Error(`MISSING_DATA: Cannot parse ${t} for an unknown reason`);throw e.code="MISSING_DATA",e}const n=l(e).split(","),o=n.length;let i;for(let e=0;e<o;e++)try{const t=p(r,n[e].trim());i=d.decrypt(t.ciphertext,t.key);break}catch(t){if(e+1>=o)throw t}return d.parse(i)},config:function(e){if(0===l(e).length)return d.configDotenv(e);const t=f(e);return t?d._configVault(e):(r=`You set DOTENV_KEY but you are missing a .env.vault file at ${t}. Did you forget to build it?`,console.log(`[dotenv@${a}][WARN] ${r}`),d.configDotenv(e));var r},decrypt:function(e,t){const r=Buffer.from(t.slice(-64),"hex");let n=Buffer.from(e,"base64");const o=n.subarray(0,12),i=n.subarray(-16);n=n.subarray(12,-16);try{const e=s.createDecipheriv("aes-256-gcm",r,o);return e.setAuthTag(i),`${e.update(n)}${e.final()}`}catch(e){const t=e instanceof RangeError,r="Invalid key length"===e.message,n="Unsupported state or unable to authenticate data"===e.message;if(t||r){const e=new Error("INVALID_DOTENV_KEY: It must be 64 characters long (or more)");throw e.code="INVALID_DOTENV_KEY",e}if(n){const e=new Error("DECRYPTION_FAILED: Please check your DOTENV_KEY");throw e.code="DECRYPTION_FAILED",e}throw e}},parse:function(e){const t={};let r,n=e.toString();for(n=n.replace(/\r\n?/gm,"\n");null!=(r=c.exec(n));){const e=r[1];let n=r[2]||"";n=n.trim();const o=n[0];n=n.replace(/^(['"`])([\s\S]*)\1$/gm,"$2"),'"'===o&&(n=n.replace(/\\n/g,"\n"),n=n.replace(/\\r/g,"\r")),t[e]=n}return t},populate:function(e,t,r={}){const n=Boolean(r&&r.debug),o=Boolean(r&&r.override);if("object"!=typeof t){const e=new Error("OBJECT_REQUIRED: Please check the processEnv argument being passed to populate");throw e.code="OBJECT_REQUIRED",e}for(const r of Object.keys(t))Object.prototype.hasOwnProperty.call(e,r)?(!0===o&&(e[r]=t[r]),n&&u(!0===o?`"${r}" is already defined and WAS overwritten`:`"${r}" is already defined and was NOT overwritten`)):e[r]=t[r]}};e.exports.configDotenv=d.configDotenv,e.exports._configVault=d._configVault,e.exports._parseVault=d._parseVault,e.exports.config=d.config,e.exports.decrypt=d.decrypt,e.exports.parse=d.parse,e.exports.populate=d.populate,e.exports=d},698:e=>{"function"==typeof Object.create?e.exports=function(e,t){e.super_=t,e.prototype=Object.create(t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}})}:e.exports=function(e,t){e.super_=t;var r=function(){};r.prototype=t.prototype,e.prototype=new r,e.prototype.constructor=e}},627:(e,t,r)=>{"use strict";var n="win32"===process.platform,o=r(537);function i(e,t){for(var r=[],n=0;n<e.length;n++){var o=e[n];o&&"."!==o&&(".."===o?r.length&&".."!==r[r.length-1]?r.pop():t&&r.push(".."):r.push(o))}return r}function s(e){for(var t=e.length-1,r=0;r<=t&&!e[r];r++);for(var n=t;n>=0&&!e[n];n--);return 0===r&&n===t?e:r>n?[]:e.slice(r,n+1)}var a=/^([a-zA-Z]:|[\\\/]{2}[^\\\/]+[\\\/]+[^\\\/]+)?([\\\/])?([\s\S]*?)$/,c=/^([\s\S]*?)((?:\.{1,2}|[^\\\/]+?|)(\.[^.\/\\]*|))(?:[\\\/]*)$/,u={};function l(e){var t=a.exec(e),r=(t[1]||"")+(t[2]||""),n=t[3]||"",o=c.exec(n);return[r,o[1],o[2],o[3]]}function p(e){var t=a.exec(e),r=t[1]||"",n=!!r&&":"!==r[1];return{device:r,isUnc:n,isAbsolute:n||!!t[2],tail:t[3]}}function f(e){return"\\\\"+e.replace(/^[\\\/]+/,"").replace(/[\\\/]+/g,"\\")}u.resolve=function(){for(var e="",t="",r=!1,n=arguments.length-1;n>=-1;n--){var s;if(n>=0?s=arguments[n]:e?(s="MISSING_ENV_VAR"["="+e])&&s.substr(0,3).toLowerCase()===e.toLowerCase()+"\\"||(s=e+"\\"):s=process.cwd(),!o.isString(s))throw new TypeError("Arguments to path.resolve must be strings");if(s){var a=p(s),c=a.device,u=a.isUnc,l=a.isAbsolute,g=a.tail;if((!c||!e||c.toLowerCase()===e.toLowerCase())&&(e||(e=c),r||(t=g+"\\"+t,r=l),e&&r))break}}return u&&(e=f(e)),e+(r?"\\":"")+(t=i(t.split(/[\\\/]+/),!r).join("\\"))||"."},u.normalize=function(e){var t=p(e),r=t.device,n=t.isUnc,o=t.isAbsolute,s=t.tail,a=/[\\\/]$/.test(s);return(s=i(s.split(/[\\\/]+/),!o).join("\\"))||o||(s="."),s&&a&&(s+="\\"),n&&(r=f(r)),r+(o?"\\":"")+s},u.isAbsolute=function(e){return p(e).isAbsolute},u.join=function(){for(var e=[],t=0;t<arguments.length;t++){var r=arguments[t];if(!o.isString(r))throw new TypeError("Arguments to path.join must be strings");r&&e.push(r)}var n=e.join("\\");return/^[\\\/]{2}[^\\\/]/.test(e[0])||(n=n.replace(/^[\\\/]{2,}/,"\\")),u.normalize(n)},u.relative=function(e,t){e=u.resolve(e),t=u.resolve(t);for(var r=e.toLowerCase(),n=t.toLowerCase(),o=s(t.split("\\")),i=s(r.split("\\")),a=s(n.split("\\")),c=Math.min(i.length,a.length),l=c,p=0;p<c;p++)if(i[p]!==a[p]){l=p;break}if(0==l)return t;var f=[];for(p=l;p<i.length;p++)f.push("..");return(f=f.concat(o.slice(l))).join("\\")},u._makeLong=function(e){if(!o.isString(e))return e;if(!e)return"";var t=u.resolve(e);return/^[a-zA-Z]\:\\/.test(t)?"\\\\?\\"+t:/^\\\\[^?.]/.test(t)?"\\\\?\\UNC\\"+t.substring(2):e},u.dirname=function(e){var t=l(e),r=t[0],n=t[1];return r||n?(n&&(n=n.substr(0,n.length-1)),r+n):"."},u.basename=function(e,t){var r=l(e)[2];return t&&r.substr(-1*t.length)===t&&(r=r.substr(0,r.length-t.length)),r},u.extname=function(e){return l(e)[3]},u.format=function(e){if(!o.isObject(e))throw new TypeError("Parameter 'pathObject' must be an object, not "+typeof e);var t=e.root||"";if(!o.isString(t))throw new TypeError("'pathObject.root' must be a string or undefined, not "+typeof e.root);var r=e.dir,n=e.base||"";return r?r[r.length-1]===u.sep?r+n:r+u.sep+n:n},u.parse=function(e){if(!o.isString(e))throw new TypeError("Parameter 'pathString' must be a string, not "+typeof e);var t=l(e);if(!t||4!==t.length)throw new TypeError("Invalid path '"+e+"'");return{root:t[0],dir:t[0]+t[1].slice(0,-1),base:t[2],ext:t[3],name:t[2].slice(0,t[2].length-t[3].length)}},u.sep="\\",u.delimiter=";";var g=/^(\/?|)([\s\S]*?)((?:\.{1,2}|[^\/]+?|)(\.[^.\/]*|))(?:[\/]*)$/,d={};function h(e){return g.exec(e).slice(1)}d.resolve=function(){for(var e="",t=!1,r=arguments.length-1;r>=-1&&!t;r--){var n=r>=0?arguments[r]:process.cwd();if(!o.isString(n))throw new TypeError("Arguments to path.resolve must be strings");n&&(e=n+"/"+e,t="/"===n[0])}return(t?"/":"")+(e=i(e.split("/"),!t).join("/"))||"."},d.normalize=function(e){var t=d.isAbsolute(e),r=e&&"/"===e[e.length-1];return(e=i(e.split("/"),!t).join("/"))||t||(e="."),e&&r&&(e+="/"),(t?"/":"")+e},d.isAbsolute=function(e){return"/"===e.charAt(0)},d.join=function(){for(var e="",t=0;t<arguments.length;t++){var r=arguments[t];if(!o.isString(r))throw new TypeError("Arguments to path.join must be strings");r&&(e+=e?"/"+r:r)}return d.normalize(e)},d.relative=function(e,t){e=d.resolve(e).substr(1),t=d.resolve(t).substr(1);for(var r=s(e.split("/")),n=s(t.split("/")),o=Math.min(r.length,n.length),i=o,a=0;a<o;a++)if(r[a]!==n[a]){i=a;break}var c=[];for(a=i;a<r.length;a++)c.push("..");return(c=c.concat(n.slice(i))).join("/")},d._makeLong=function(e){return e},d.dirname=function(e){var t=h(e),r=t[0],n=t[1];return r||n?(n&&(n=n.substr(0,n.length-1)),r+n):"."},d.basename=function(e,t){var r=h(e)[2];return t&&r.substr(-1*t.length)===t&&(r=r.substr(0,r.length-t.length)),r},d.extname=function(e){return h(e)[3]},d.format=function(e){if(!o.isObject(e))throw new TypeError("Parameter 'pathObject' must be an object, not "+typeof e);var t=e.root||"";if(!o.isString(t))throw new TypeError("'pathObject.root' must be a string or undefined, not "+typeof e.root);return(e.dir?e.dir+d.sep:"")+(e.base||"")},d.parse=function(e){if(!o.isString(e))throw new TypeError("Parameter 'pathString' must be a string, not "+typeof e);var t=h(e);if(!t||4!==t.length)throw new TypeError("Invalid path '"+e+"'");return t[1]=t[1]||"",t[2]=t[2]||"",t[3]=t[3]||"",{root:t[0],dir:t[0]+t[1].slice(0,-1),base:t[2],ext:t[3],name:t[2].slice(0,t[2].length-t[3].length)}},d.sep="/",d.delimiter=":",e.exports=n?u:d,e.exports.posix=d,e.exports.win32=u},135:e=>{e.exports=function(e){return e&&"object"==typeof e&&"function"==typeof e.copy&&"function"==typeof e.fill&&"function"==typeof e.readUInt8}},537:(e,t,r)=>{var n=/%[sdj%]/g;t.format=function(e){if(!v(e)){for(var t=[],r=0;r<arguments.length;r++)t.push(s(arguments[r]));return t.join(" ")}r=1;for(var o=arguments,i=o.length,a=String(e).replace(n,(function(e){if("%%"===e)return"%";if(r>=i)return e;switch(e){case"%s":return String(o[r++]);case"%d":return Number(o[r++]);case"%j":try{return JSON.stringify(o[r++])}catch(e){return"[Circular]"}default:return e}})),c=o[r];r<i;c=o[++r])d(c)||!m(c)?a+=" "+c:a+=" "+s(c);return a},t.deprecate=function(e,n){if(y(r.g.process))return function(){return t.deprecate(e,n).apply(this,arguments)};if(!0===process.noDeprecation)return e;var o=!1;return function(){if(!o){if(process.throwDeprecation)throw new Error(n);process.traceDeprecation?console.trace(n):console.error(n),o=!0}return e.apply(this,arguments)}};var o,i={};function s(e,r){var n={seen:[],stylize:c};return arguments.length>=3&&(n.depth=arguments[2]),arguments.length>=4&&(n.colors=arguments[3]),g(r)?n.showHidden=r:r&&t._extend(n,r),y(n.showHidden)&&(n.showHidden=!1),y(n.depth)&&(n.depth=2),y(n.colors)&&(n.colors=!1),y(n.customInspect)&&(n.customInspect=!0),n.colors&&(n.stylize=a),u(n,e,n.depth)}function a(e,t){var r=s.styles[t];return r?"["+s.colors[r][0]+"m"+e+"["+s.colors[r][1]+"m":e}function c(e,t){return e}function u(e,r,n){if(e.customInspect&&r&&N(r.inspect)&&r.inspect!==t.inspect&&(!r.constructor||r.constructor.prototype!==r)){var o=r.inspect(n,e);return v(o)||(o=u(e,o,n)),o}var i=function(e,t){if(y(t))return e.stylize("undefined","undefined");if(v(t)){var r="'"+JSON.stringify(t).replace(/^"|"$/g,"").replace(/'/g,"\\'").replace(/\\"/g,'"')+"'";return e.stylize(r,"string")}return h(t)?e.stylize(""+t,"number"):g(t)?e.stylize(""+t,"boolean"):d(t)?e.stylize("null","null"):void 0}(e,r);if(i)return i;var s=Object.keys(r),a=function(e){var t={};return e.forEach((function(e,r){t[e]=!0})),t}(s);if(e.showHidden&&(s=Object.getOwnPropertyNames(r)),w(r)&&(s.indexOf("message")>=0||s.indexOf("description")>=0))return l(r);if(0===s.length){if(N(r)){var c=r.name?": "+r.name:"";return e.stylize("[Function"+c+"]","special")}if(b(r))return e.stylize(RegExp.prototype.toString.call(r),"regexp");if(E(r))return e.stylize(Date.prototype.toString.call(r),"date");if(w(r))return l(r)}var m,_="",O=!1,j=["{","}"];return f(r)&&(O=!0,j=["[","]"]),N(r)&&(_=" [Function"+(r.name?": "+r.name:"")+"]"),b(r)&&(_=" "+RegExp.prototype.toString.call(r)),E(r)&&(_=" "+Date.prototype.toUTCString.call(r)),w(r)&&(_=" "+l(r)),0!==s.length||O&&0!=r.length?n<0?b(r)?e.stylize(RegExp.prototype.toString.call(r),"regexp"):e.stylize("[Object]","special"):(e.seen.push(r),m=O?function(e,t,r,n,o){for(var i=[],s=0,a=t.length;s<a;++s)D(t,String(s))?i.push(p(e,t,r,n,String(s),!0)):i.push("");return o.forEach((function(o){o.match(/^\d+$/)||i.push(p(e,t,r,n,o,!0))})),i}(e,r,n,a,s):s.map((function(t){return p(e,r,n,a,t,O)})),e.seen.pop(),function(e,t,r){return e.reduce((function(e,t){return t.indexOf("\n"),e+t.replace(/\u001b\[\d\d?m/g,"").length+1}),0)>60?r[0]+(""===t?"":t+"\n ")+" "+e.join(",\n  ")+" "+r[1]:r[0]+t+" "+e.join(", ")+" "+r[1]}(m,_,j)):j[0]+_+j[1]}function l(e){return"["+Error.prototype.toString.call(e)+"]"}function p(e,t,r,n,o,i){var s,a,c;if((c=Object.getOwnPropertyDescriptor(t,o)||{value:t[o]}).get?a=c.set?e.stylize("[Getter/Setter]","special"):e.stylize("[Getter]","special"):c.set&&(a=e.stylize("[Setter]","special")),D(n,o)||(s="["+o+"]"),a||(e.seen.indexOf(c.value)<0?(a=d(r)?u(e,c.value,null):u(e,c.value,r-1)).indexOf("\n")>-1&&(a=i?a.split("\n").map((function(e){return"  "+e})).join("\n").substr(2):"\n"+a.split("\n").map((function(e){return"   "+e})).join("\n")):a=e.stylize("[Circular]","special")),y(s)){if(i&&o.match(/^\d+$/))return a;(s=JSON.stringify(""+o)).match(/^"([a-zA-Z_][a-zA-Z_0-9]*)"$/)?(s=s.substr(1,s.length-2),s=e.stylize(s,"name")):(s=s.replace(/'/g,"\\'").replace(/\\"/g,'"').replace(/(^"|"$)/g,"'"),s=e.stylize(s,"string"))}return s+": "+a}function f(e){return Array.isArray(e)}function g(e){return"boolean"==typeof e}function d(e){return null===e}function h(e){return"number"==typeof e}function v(e){return"string"==typeof e}function y(e){return void 0===e}function b(e){return m(e)&&"[object RegExp]"===_(e)}function m(e){return"object"==typeof e&&null!==e}function E(e){return m(e)&&"[object Date]"===_(e)}function w(e){return m(e)&&("[object Error]"===_(e)||e instanceof Error)}function N(e){return"function"==typeof e}function _(e){return Object.prototype.toString.call(e)}function O(e){return e<10?"0"+e.toString(10):e.toString(10)}t.debuglog=function(e){if(y(o)&&(o="MISSING_ENV_VAR".NODE_DEBUG||""),e=e.toUpperCase(),!i[e])if(new RegExp("\\b"+e+"\\b","i").test(o)){var r=process.pid;i[e]=function(){var n=t.format.apply(t,arguments);console.error("%s %d: %s",e,r,n)}}else i[e]=function(){};return i[e]},t.inspect=s,s.colors={bold:[1,22],italic:[3,23],underline:[4,24],inverse:[7,27],white:[37,39],grey:[90,39],black:[30,39],blue:[34,39],cyan:[36,39],green:[32,39],magenta:[35,39],red:[31,39],yellow:[33,39]},s.styles={special:"cyan",number:"yellow",boolean:"yellow",undefined:"grey",null:"bold",string:"green",date:"magenta",regexp:"red"},t.isArray=f,t.isBoolean=g,t.isNull=d,t.isNullOrUndefined=function(e){return null==e},t.isNumber=h,t.isString=v,t.isSymbol=function(e){return"symbol"==typeof e},t.isUndefined=y,t.isRegExp=b,t.isObject=m,t.isDate=E,t.isError=w,t.isFunction=N,t.isPrimitive=function(e){return null===e||"boolean"==typeof e||"number"==typeof e||"string"==typeof e||"symbol"==typeof e||void 0===e},t.isBuffer=r(135);var j=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];function D(e,t){return Object.prototype.hasOwnProperty.call(e,t)}t.log=function(){var e,r;console.log("%s - %s",(r=[O((e=new Date).getHours()),O(e.getMinutes()),O(e.getSeconds())].join(":"),[e.getDate(),j[e.getMonth()],r].join(" ")),t.format.apply(t,arguments))},t.inherits=r(698),t._extend=function(e,t){if(!t||!m(t))return e;for(var r=Object.keys(t),n=r.length;n--;)e[r[n]]=t[r[n]];return e}},682:()=>{},16:()=>{},667:()=>{},56:e=>{"use strict";e.exports=JSON.parse('{"name":"dotenv","version":"16.4.5","description":"Loads environment variables from .env file","main":"lib/main.js","types":"lib/main.d.ts","exports":{".":{"types":"./lib/main.d.ts","require":"./lib/main.js","default":"./lib/main.js"},"./config":"./config.js","./config.js":"./config.js","./lib/env-options":"./lib/env-options.js","./lib/env-options.js":"./lib/env-options.js","./lib/cli-options":"./lib/cli-options.js","./lib/cli-options.js":"./lib/cli-options.js","./package.json":"./package.json"},"scripts":{"dts-check":"tsc --project tests/types/tsconfig.json","lint":"standard","lint-readme":"standard-markdown","pretest":"npm run lint && npm run dts-check","test":"tap tests/*.js --100 -Rspec","test:coverage":"tap --coverage-report=lcov","prerelease":"npm test","release":"standard-version"},"repository":{"type":"git","url":"git://github.com/motdotla/dotenv.git"},"funding":"https://dotenvx.com","keywords":["dotenv","env",".env","environment","variables","config","settings"],"readmeFilename":"README.md","license":"BSD-2-Clause","devDependencies":{"@definitelytyped/dtslint":"^0.0.133","@types/node":"^18.11.3","decache":"^4.6.1","sinon":"^14.0.1","standard":"^17.0.0","standard-markdown":"^7.1.0","standard-version":"^9.5.0","tap":"^16.3.0","tar":"^6.1.11","typescript":"^4.8.4"},"engines":{"node":">=12"},"browser":{"fs":false}}')}}]);