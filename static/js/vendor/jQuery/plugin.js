!function(a){function b(a){var b;return a=a||0,b=Math.floor(a/60),{days:a>=n.DAYINSECONDS?Math.floor(a/n.DAYINSECONDS):0,hours:a>=3600?Math.floor(a%n.DAYINSECONDS/3600):0,totalMinutes:b,minutes:a>=60?Math.floor(a%3600/60):b,seconds:a%60,totalSeconds:a}}function c(a){return((a=parseInt(a,10))<10&&"0")+a}function d(){return{seconds:0,editable:!1,duration:null,callback:function(){console.log("Time up!")},repeat:!1,countdown:!1,format:null,updateFrequency:500}}function e(){return Math.round((Date.now?Date.now():(new Date).getTime())/1e3)}function f(a){var d=b(a);if(d.days)return d.days+":"+c(d.hours)+":"+c(d.minutes)+":"+c(d.seconds);if(d.hours)return d.hours+":"+c(d.minutes)+":"+c(d.seconds);return d.minutes?d.minutes+":"+c(d.seconds)+" min":d.seconds+" sec"}function g(a,d){for(var e=b(a),f=[{identifier:"%d",value:e.days},{identifier:"%h",value:e.hours},{identifier:"%m",value:e.minutes},{identifier:"%s",value:e.seconds},{identifier:"%g",value:e.totalMinutes},{identifier:"%t",value:e.totalSeconds},{identifier:"%D",value:c(e.days)},{identifier:"%H",value:c(e.hours)},{identifier:"%M",value:c(e.minutes)},{identifier:"%S",value:c(e.seconds)},{identifier:"%G",value:c(e.totalMinutes)},{identifier:"%T",value:c(e.totalSeconds)}],g=0;g<f.length;g++)d=d.replace(f[g].identifier,f[g].value);return d}function h(a){if(!isNaN(Number(a)))return a;a=a.toLowerCase();var b=a.match(/\d+d/),c=a.match(/\d+h/),d=a.match(/\d+m/),e=a.match(/\d+s/);if(!(b||c||d||e))throw new Error("Invalid string passed in durationTimeToSeconds!");var f=0;return b&&(f+=Number(b[0].replace("d",""))*n.DAYINSECONDS),c&&(f+=3600*Number(c[0].replace("h",""))),d&&(f+=60*Number(d[0].replace("m",""))),e&&(f+=Number(e[0].replace("s",""))),f}function i(a){var b,c;return a.indexOf("sec")>0?c=Number(a.replace(/\ssec/g,"")):a.indexOf("min")>0?(a=a.replace(/\smin/g,""),b=a.split(":"),c=Number(60*b[0])+Number(b[1])):a.match(/\d{1,2}:\d{2}:\d{2}:\d{2}/)?(b=a.split(":"),c=Number(b[0]*n.DAYINSECONDS)+Number(3600*b[1])+Number(60*b[2])+Number(b[3])):a.match(/\d{1,2}:\d{2}:\d{2}/)&&(b=a.split(":"),c=Number(3600*b[0])+Number(60*b[1])+Number(b[2])),c}function j(b,c){b.state=c,a(b.element).data("state",c)}function k(b){a(b.element).on("focus",function(){b.pause()}),a(b.element).on("blur",function(){b.totalSeconds=i(a(b.element)[b.html]()),b.resume()})}function l(b){if(b.totalSeconds=e()-b.startTime,b.config.countdown)return b.totalSeconds=b.config.duration-b.totalSeconds,0===b.totalSeconds&&(clearInterval(b.intervalId),j(b,n.TIMER_STOPPED),b.config.callback(),a(b.element).data("seconds")),void b.render();b.render(),b.config.duration&&b.totalSeconds>0&&b.totalSeconds%b.config.duration==0&&(b.config.callback&&b.config.callback(),b.config.repeat||(clearInterval(b.intervalId),j(b,n.TIMER_STOPPED),b.config.duration=null))}function m(b,c){if(this.element=b,this.originalConfig=a.extend({},c),this.totalSeconds=0,this.intervalId=null,this.html="html","INPUT"!==b.tagName&&"TEXTAREA"!==b.tagName||(this.html="val"),this.config=o.getDefaultConfig(),c.duration&&(c.duration=o.durationTimeToSeconds(c.duration)),"string"!=typeof c&&(this.config=a.extend(this.config,c)),this.config.seconds&&(this.totalSeconds=this.config.seconds),this.config.editable&&o.makeEditable(this),this.startTime=o.unixSeconds()-this.totalSeconds,this.config.duration&&this.config.repeat&&this.config.updateFrequency<1e3&&(this.config.updateFrequency=1e3),this.config.countdown){if(!this.config.duration)throw new Error("Countdown option set without duration!");if(this.config.editable)throw new Error("Cannot set editable on a countdown timer!");this.config.startTime=o.unixSeconds()-this.config.duration,this.totalSeconds=this.config.duration}}var n={PLUGIN_NAME:"timer",TIMER_RUNNING:"running",TIMER_PAUSED:"paused",TIMER_REMOVED:"removed",DAYINSECONDS:86400},o={getDefaultConfig:d,unixSeconds:e,secondsToPrettyTime:f,secondsToFormattedTime:g,durationTimeToSeconds:h,prettyTimeToSeconds:i,setState:j,makeEditable:k,intervalHandler:l};m.prototype.start=function(){this.state!==n.TIMER_RUNNING&&(o.setState(this,n.TIMER_RUNNING),this.render(),this.intervalId=setInterval(o.intervalHandler.bind(null,this),this.config.updateFrequency))},m.prototype.pause=function(){this.state===n.TIMER_RUNNING&&(o.setState(this,n.TIMER_PAUSED),clearInterval(this.intervalId))},m.prototype.resume=function(){this.state===n.TIMER_PAUSED&&(o.setState(this,n.TIMER_RUNNING),this.config.countdown?this.startTime=o.unixSeconds()-this.config.duration+this.totalSeconds:this.startTime=o.unixSeconds()-this.totalSeconds,this.intervalId=setInterval(o.intervalHandler.bind(null,this),this.config.updateFrequency))},m.prototype.remove=function(){clearInterval(this.intervalId),o.setState(this,n.TIMER_REMOVED),a(this.element).data(n.PLUGIN_NAME,null),a(this.element).data("seconds",null)},m.prototype.reset=function(){var b=this.originalConfig;this.remove(),a(this.element).timer(b)},m.prototype.render=function(){this.config.format?a(this.element)[this.html](o.secondsToFormattedTime(this.totalSeconds,this.config.format)):a(this.element)[this.html](o.secondsToPrettyTime(this.totalSeconds)),a(this.element).data("seconds",this.totalSeconds)},a.fn.timer=function(b){return b=b||"start",this.each(function(){a.data(this,n.PLUGIN_NAME)instanceof m||a.data(this,n.PLUGIN_NAME,new m(this,b));var c=a.data(this,n.PLUGIN_NAME);"string"==typeof b?"function"==typeof c[b]&&c[b]():c.start()})}}(jQuery);

/*
 * jQuery appear plugin
 *
 * Copyright (c) 2012 Andrey Sidorov
 * licensed under MIT license.
 *
 * https://github.com/morr/jquery.appear/
 *
 * Version: 0.3.3
 */
(function($) {
    var selectors = [];
  
    var check_binded = false;
    var check_lock = false;
    var defaults = {
      interval: 250,
      force_process: false
    }
    var $window = $(window);
  
    var $prior_appeared;
  
    function process() {
      check_lock = false;
      for (var index = 0; index < selectors.length; index++) {
        var $appeared = $(selectors[index]).filter(function() {
          return $(this).is(':appeared');
        });
  
        $appeared.trigger('appear', [$appeared]);
  
        if ($prior_appeared) {
          var $disappeared = $prior_appeared.not($appeared);
          $disappeared.trigger('disappear', [$disappeared]);
        }
        $prior_appeared = $appeared;
      }
    }
  
    // "appeared" custom filter
    $.expr[':']['appeared'] = function(element) {
      var $element = $(element);
      if (!$element.is(':visible')) {
        return false;
      }
  
      var window_left = $window.scrollLeft();
      var window_top = $window.scrollTop();
      var offset = $element.offset();
      var left = offset.left;
      var top = offset.top;
  
      if (top + $element.height() >= window_top &&
          top - ($element.data('appear-top-offset') || 0) <= window_top + $window.height() &&
          left + $element.width() >= window_left &&
          left - ($element.data('appear-left-offset') || 0) <= window_left + $window.width()) {
        return true;
      } else {
        return false;
      }
    }
  
    $.fn.extend({
      // watching for element's appearance in browser viewport
      appear: function(options) {
        var opts = $.extend({}, defaults, options || {});
        var selector = this.selector || this;
        if (!check_binded) {
          var on_check = function() {
            if (check_lock) {
              return;
            }
            check_lock = true;
  
            setTimeout(process, opts.interval);
          };
  
          $(window).scroll(on_check).resize(on_check);
          check_binded = true;
        }
  
        if (opts.force_process) {
          setTimeout(process, opts.interval);
        }
        selectors.push(selector);
        return $(selector);
      }
    });
  
    $.extend({
      // force elements's appearance check
      force_appear: function() {
        if (check_binded) {
          process();
          return true;
        };
        return false;
      }
    });
  })(jQuery);

/*
 * jQuery appear plugin
 *
 * Copyright (c) 2012 Andrey Sidorov
 * licensed under MIT license.
 *
 * https://github.com/morr/jquery.appear/
 *
 * Version: 0.3.3
 */
(function($) {
    var selectors = [];
  
    var check_binded = false;
    var check_lock = false;
    var defaults = {
      interval: 250,
      force_process: false
    }
    var $window = $(window);
  
    var $prior_appeared;
  
    function process() {
      check_lock = false;
      for (var index = 0; index < selectors.length; index++) {
        var $appeared = $(selectors[index]).filter(function() {
          return $(this).is(':appeared');
        });
  
        $appeared.trigger('appear', [$appeared]);
  
        if ($prior_appeared) {
          var $disappeared = $prior_appeared.not($appeared);
          $disappeared.trigger('disappear', [$disappeared]);
        }
        $prior_appeared = $appeared;
      }
    }
  
    // "appeared" custom filter
    $.expr[':']['appeared'] = function(element) {
      var $element = $(element);
      if (!$element.is(':visible')) {
        return false;
      }
  
      var window_left = $window.scrollLeft();
      var window_top = $window.scrollTop();
      var offset = $element.offset();
      var left = offset.left;
      var top = offset.top;
  
      if (top + $element.height() >= window_top &&
          top - ($element.data('appear-top-offset') || 0) <= window_top + $window.height() &&
          left + $element.width() >= window_left &&
          left - ($element.data('appear-left-offset') || 0) <= window_left + $window.width()) {
        return true;
      } else {
        return false;
      }
    }
  
    $.fn.extend({
      // watching for element's appearance in browser viewport
      appear: function(options) {
        var opts = $.extend({}, defaults, options || {});
        var selector = this.selector || this;
        if (!check_binded) {
          var on_check = function() {
            if (check_lock) {
              return;
            }
            check_lock = true;
  
            setTimeout(process, opts.interval);
          };
  
          $(window).scroll(on_check).resize(on_check);
          check_binded = true;
        }
  
        if (opts.force_process) {
          setTimeout(process, opts.interval);
        }
        selectors.push(selector);
        return $(selector);
      }
    });
  
    $.extend({
      // force elements's appearance check
      force_appear: function() {
        if (check_binded) {
          process();
          return true;
        };
        return false;
      }
    });
  })(jQuery);