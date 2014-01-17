CIP-dashboard
=============
A dashboard for showing different statistics of a CIP database.

Running CIP-dashboard
--------------------
The dashboard loads CIP statistics from MongoDB, and you must specify a url
containing username and password in the `CIP_DAEMON_MONGODB_URL` environment
variable.

You can then test the dashboard like this:

    > CIP_DAEMON_MONGODB_URL=username@password:mongodb.com php -S localhost:8000

or

    > export CIP_DASHBOARD_MONGODB_URL='mongodb://username:password@example.org:port/'
    > php -S localhost:8000

And go to <http://localhost:8000> to check it out.

Adding widgets
--------------
The easiest way to add widgets is to create an HTML file containing the HTML you
want inside your widget.
Then load the file via the `CIPdashboard.loadWidgets()` function:

    CIPdashboard.loadWidgets([
      // [url, sizex, sizey]
      ['widgets/piechart/piechart.html',     1, 1],
      ['widgets/percentage/percentage.html', 2, 1]
    ]);

The numbers at the end of each entry are the width and height of the widget
respecitively. The dashboard is divided into cells, and the numbers specify how
many cells the widget spans in the horizontal and vertical direction.

The HTML files should not contain `<html>`, `<head>` and `<body>` tags. The
content of the file will be put directly into the widget element.

### Manually inserting a widget

You can also add your dashboard widget manually like this:

    CIPdashboard.ready(function() {
      console.log('custom widget loaded');
      var $widget = $('<h1>Custom widget</h1>');
      CIPdashboard.addWidget($widget, 1, 1);
    });

`CIPdashboard.ready(handler)` accepts as its onlu argument a handler to be
called when the dashboard is readu.

`CIPdashboard.addWidget($html, sizex, sizey)` accepts three arguments. The first
is the HTML content wrapped in jQuery. The second is the width of the widget in
blocks. The third is the height of the widget in blocks.

Configuration
-------------
You can change the title of the dashboard by setting a value called
`dashboard-title` in a JSON file `conf.json` placed in the same directory as
`index.html`.

For an example please check out `conf.example.json`.
