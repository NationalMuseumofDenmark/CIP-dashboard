// `console.log` is not readily defined in Internet Explorer 8
// (only after you have opened the developer console)
define(function() {
  var safe_log = function(message) {
    try {
      console.log(message);
    } catch(e) {
      // do nothing
    }
  };

  return {
    log: safe_log
  };
});

