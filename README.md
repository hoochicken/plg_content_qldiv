# qldiv

To call the plugin in article text add start tag {'qldiv} and end tag {'/qldiv} into article text (of course without '). The text inbetween the tags is going to be displayed in a div.
Additionally you can add an id, class name or style commands in the start tag, e. g.

* {qldiv class="grey"} generates <div class="grey">
* {qldiv id=weather} generates <div id="weather">
* {qldiv style=background:red;font-size:10px;} generates <div  style="background:red;font-size:10px;">

Mind to separate the attributes with comma

~~~shell
{qldiv id=weather,class=grey,style=background:red;font-size:10px;}Und hier ist ein Inhalt drin{/qldiv}
~~~

This tag generates

~~~shell
<div class="grey" id="weather" style="background:red;font-size:10px;">Und hier ist ein Inhalt drin</qldiv>
~~~
