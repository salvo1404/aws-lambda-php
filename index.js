'use strict';

var child_process = require('child_process');

exports.handler = function(event, context, callback) {

  var output = '';

  var php = child_process.spawn( './php', [ '-c', 'php.ini', 'index.php' ] );

  //send the input event json as string via STDIN to php process
  php.stdin.write(JSON.stringify(event));

  //close the php stream to unblock php process
  php.stdin.end();

  //dynamically collect php output
  php.stdout.on('data', function (data) {

    console.log('stdout: ' + data);
    output += data;
  });

  //react to potential errors
  php.stderr.on('data', function(data) {
    console.log('STDERR: '+data);
  });

  php.on('close', function(code) {
    if(code !== 0) {
      console.log('Error code: '+code);
      return context.done(new Error("Process exited with non-zero status code"));
    }

    context.succeed( JSON.parse( output ) );
  });
};