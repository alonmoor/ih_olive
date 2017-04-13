jQuery.print = function(value, insertionType) {
  function nestedRepresentation(value) {
    var output = '';
    if (value && value.nodeName) {
      output += '&lt;' + value.nodeName.toLowerCase();
      output += value.className ? ' class="' + value.className + '"' : '';
      output += value.id ? ' id="' + value.id + '"' : '';
      output += '&gt;';
    }
    else if (value instanceof Array) {
      output += '[<blockquote>';
      for (var i = 0; i < value.length; i++) {
        output += nestedRepresentation(value[i]) + ',<br />';
      }
      output += '</blockquote>]';
    }
    else if (typeof value == 'object') {
      output += '{<blockquote>';
      $.each(value, function(key, objValue) {
        output += key + ': ' + nestedRepresentation(objValue) + '<br />';
      });
      output += '</blockquote>}';
    }
    else {
      output += value;
    }
    return output;
  }
  
  var message = nestedRepresentation(value);

  var $output = $('#print-output');
  
  if ($output.length === 0) {
    $output = $('<div id="print-output" />').appendTo('body');
  }
  
  var $newMessage = $('<div class="print-output-line" />');
  $newMessage.html(message);
  insertionType = insertionType || 'append';
  $output[insertionType]($newMessage);
};
