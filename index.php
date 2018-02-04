<?php
$dir = __DIR__;

$request = str_replace('../','/',$_SERVER['REQUEST_URI']);

if(preg_match('~/w/page/\d+/(.+\?rev=\d+)~', $request, $match)) {
  $request = '/w/page/'.$match[1];
}

$htmlfilename = $dir.$request.'/index.html';
$filename = $dir.$request;

if(file_exists($htmlfilename)) {
  $html = file_get_contents($htmlfilename);
  $html = str_replace('http://vs1.pbworks.com/shared/statics/packed-m-prod-v07998121.css', '/assets/styles.css', $html);
  $html = str_replace('UA-2694787-12', 'UA-4617305-33', $html);

  $archive_warning = file_get_contents('archived.html');
  $html = preg_replace('/<body[^>]+>/', '$0'.$archive_warning, $html);

  echo $html;
} elseif(file_exists($filename)) {
  if(preg_match('/theme_image/', $filename)) {
    header('Content-type: image/png');
  }
  readfile($filename);
} else {
  header('HTTP/1.1 404 Not Found');
  ?>
  <html>
    <head>
      <title>Not Found</title>
      <link rel="stylesheet" href="/assets/styles.css">
    </head>
    <body>
      <div style="max-width: 500px; margin: 20px auto;">
        <p>Sorry, that page was not found in the archives. You can try searching the Internet Archive for it below.</p>
        <p><a href=""></a></p>
      </div>
    </body>
  </html>
  <?php
}

