<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>IRC Drawing Bot</title>
    <meta name="description" content="IRC Drawing Bot">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/blog/irc-drawing-bot/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Creating the IRC Drawing Bot</h1>
    <hr>
    <p><b>Sunday 14th May 2017</b></p>
    <p>Last week, I launched my new web project, the <a href="/projects/irc-drawing-bot/" target="_blank">IRC Drawing Bot</a>. This is a proof of concept and demonstration of handling web page inputs using IRC bot commands.</p>
    <h2>The Concept</h2>
    <p>The idea to do this first came into my mind when I wanted a secure way to handle user inputs on a web page. Instead of going down the usual PHP forms route, I wanted to try something different and see if it could be implemented securely.</p>
    <p>I had many different ideas for what to make for the demonstration, including a basic game, moving an object around the screen, and even a chat room (how ironic!). I ended up settling with the collaborative pixel canvas, of course inspired from <a href="https://www.reddit.com/r/place" target="_blank">Reddit's r/place</a>. Keep in mind though, that my demonstration is not designed to be a fancy art project!</p>
    <center><table class="irc">
        <tr><td bgcolor="blue"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td></tr>
        <tr><td bgcolor="white"></td><td bgcolor="red"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="pink"></td><td bgcolor="white"></td><td bgcolor="green"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td></tr>
        <tr><td bgcolor="pink"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td></tr>
        <tr><td bgcolor="white"></td><td bgcolor="red"></td><td bgcolor="green"></td><td bgcolor="black"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td><td bgcolor="red"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td></tr>
        <tr><td bgcolor="white"></td><td bgcolor="orange"></td><td bgcolor="red"></td><td bgcolor="white"></td><td bgcolor="brown"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="red"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="brown"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="green"></td></tr>
        <tr><td bgcolor="white"></td><td bgcolor="blue"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="green"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td></tr>
        <tr><td bgcolor="blue"></td><td bgcolor="blue"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td><td bgcolor="brown"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td></tr>
        <tr><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="green"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="red"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td></tr>
        <tr><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="yellow"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="yellow"></td></tr>
        <tr><td bgcolor="blue"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="white"></td><td bgcolor="blue"></td><td bgcolor="blue"></td></tr>
    </table><p class="two-mar-top"><i>The canvas as of Monday 8th May 2017, 7:22pm.</i></p></center>
    <p>I'd been considering the idea of using IRC for user input handling for quite a long time, however I could not find a way to implement it in the way that I desired while maintaining security. The original concept that I had for this was that the user would interract with the page completely normally, but in the background their inputs would be sent to an IRC server to be processed. The fact that IRC was even involved was supposed to be transparent to the end user.</p>
    <p>The reason that I was unable to achieve this is the fact that it is pretty much impossible for a web browser to make a connection to an IRC server by itself. JavaScript is unable to make direct web socket connections, so I would have to rely on something else to make the IRC connection. I was hoping there would be a JavaScript API for an online IRC client, but unfortunately I could not find anything suitable. I ideally wanted to avoid JavaScript anyway, since using it would violate my no-JavaScript rule. At this point I realised that I was asking too much of a static HTML/PHP website. The only way around this would be to have the IRC connection be made server-side, but this completely defeats the purpose of the experiment since then I would still have to handle a sockets connection between the client and server.</p>
    <p>This is where I decided that I'd have to drop the user transparency idea, instead making it revolve around controlling the IRC bot manually. This opened up a few interesting things, such as the fact that multiple users can control the bot at the same time, allowing both collaboration and conflict. If a user is trying to paint a pixel at a particular coordinate, another user could come along and take over by issuing counter-commands. It would be possible to have separate bot sessions for each user on the IRC channel, however having only one is simpler and makes it more interesting.</p>
    <h2>Creating the IRC Bot</h2>
    <p>At first, I was expecting that I'd have to use some sort of IRC library in order to interface with the IRC server. To my pleasant surprise, IRC is incredibly easy to interact with without any sort of specific library or tools, you can just make a direct web sockets connection to the server and send the relevant authentication/registration commands. After doing some research into this, I found a <a href="https://gist.github.com/Xeoncross/2370545" target="_blank">GitHub Gist of a basic PHP IRC client</a>, made by <a href="https://github.com/Xeoncross/" target="_blank">Xeoncross</a> which allowed for a basic connection to an IRC server. This code is what my bot is based on.</p>
    <p>I heavily modified the code in order to build the bot for this project, focusing heavily on user input validation and security in general. Stripping everything except necessary characters is the first thing that happens when data is read from the sockets connection. Everything is stripped using preg_replace except for a-z, 0-9, exclamation mark (!) and space ( ). This alleviates most forms of command injection before the data is even processed, never mind output into a different format (which is where command injection is normally exploited). The only reason for leaving the exclamation mark in there is because it is used as the prefix for bot commands. While I could get away with stripping it as well, it would result in the bot been triggerable by normal conversation. This is not a problem, but is not particularly user friendly.</p>
    <p>As soon as a command is detected, the data received from the web socket is sanitized even more, removing everything except characters that may be required by the command. The command arguments are validated precisely with regex, making sure that nothing at all can get through except for legitimate inputs. I am aware that it is usually safe to handle unsanitized data solely within PHP, and that injection normally takes place when that data leaves PHP and is used in another format, such as HTML or commands to an SQL server, but adding this extreme validation has basically no cost and helps to protect against general spam/abuse or the unlikely event that there was a vulnerability in PHP itself.</p>
    <p>One of the most important parts of the validation is to ensure that user input is never used directly for any sort of external influence. When the bot sets the colour, it not taking the colour directly from user input, validating it and then setting the colour value to the one from user input. Instead, it takes it from user input, validates it, then sets the colour using a predefined string in the bot code. For example, if a user sets the colour to "red", the bot will never put that text directly in the config file, it will simply see that it passed validation for been "red", but then set the colour to "red" using it's own predefined string. This is quite difficult to explain, but you should understand it easily by looking at the code. Again, this is to help prevent an attack as the result of a vulnerability in PHP itself. It could also prevent an attack involving something to do with non-standard character encoding or unusual, possibly malformed characters. The only place that user input is echoed back to the user is when the bot outputs the confirmation of commands, for example "Moving pen to: 5, 6". This is accpetable since those values are heavily sanitized as integers only, and the IRC server has its own validation.</p>
    <p>The bot listens out for commands and acts accordingly when one arrives. The variables for the currently selected colour and pen position are simply stored as variables within the bot program, and are reset whenever the bot restarts. A configuration file is used to store the colours of the pixel canvas. When the bot program is started, the configuration file is loaded and stored as a multidimensional array, allowing the different elements of the array to be easily written to using coordinates. When a pixel is changed, the config file is rewritten ready to be rendered by the web page. An example configuration file is shown below:</p>
    <pre class="two-mar-bottom">blue white white white white white white white white white:
white red white white white white white pink white green:
pink white white white white white white white white white:
white red green blue white white white white blue red:
white orange red white brown white white white white red:
white blue white white white green white white white white:
blue blue white white blue brown white white white white:
white white green white white red white white white white:
white white white white yellow white white white white white:
white white white white white white white white white blue</pre>
    <center><p class="two-mar-top"><i>This config file has been reduced to 10x10 pixels, since the actual 20x10 pixels config is too large to fit on the page.</i></p></center>
    <p>Notice how the ends of all lines have a colon, except for the final one. This is used when rendering the configuration file for display. PHP allows for very easy handling of JSON, especially with multidimensional arrays, so you may think that it may be better to use JSON formatting for the configuration, instead of my own random format. I thought this too, but rendering the configuration file is much easier using this format, so it's worth the extra programming effort on the bot's end. You can see the rendering code <a href="https://github.com/JamieOnUbuntu/jamieweb/blob/master/projects/irc-drawing-bot/index.php" target="_blank">on Github, line 24</a>. It is very simple, the spaces/colons are replaced with the HTML elements to make up a table, leaving the colour names in the bgcolor slots.</p>
    <p>The bot is available on GitHub at: <a href="https://github.com/JamieOnUbuntu/irc-drawing-bot/" target="_blank">https://github.com/JamieOnUbuntu/irc-drawing-bot/</a>.
    <h2>Setting up an IRC Server</h2>
    <p>While developing the IRC bot, I was using the ##jamieweb channel on Freenode IRC for testing. I did want to set up my own IRC server though, since then I am in full control. I was also unsure of the bot policies on Freenode.</p>
    <p>I'd used IRC occasionally for a long time, but I'd never really looked into the server-side of things. The closest I had come prior to this project was registering the ##jamieweb channel on Freenode in October 2014.</p>
    <p>I was surprised to see just how many different IRC server softwares were available. I had in my mind that "ircd" was the main one and I'd just install that. I had no idea that there were literally dozens to choose from. I wanted the most secure one, so I did some research was most interested in <a href="http://www.inspircd.org" target="_blank">InspIRCd</a>, but I went to Reddit for assistance. One of the InspIRCd developers, <a href="https://www.reddit.com/user/Saber_UK" target="_blank">Saber_UK</a>, was extremely helpful and I made my final descision to use InspIRCd for my IRC server.</p>
    <p>I had some issues with installation, but those were due to the fact that I was using an Ubuntu Server virtual machine that had recently been upgraded from Ubuntu 14.04 LTS to Ubuntu 16.04 LTS, causing some misconfigured/missing packages. InspIRCd was quite overwhelming at first, with lots of different things to read and configuration files to make. I like configuration files, so it was great fun! After a few hours I had gotten everything set up and working very well, but it's definitely a steep learning curve at first. I am working on an in-depth guide for installing and setting up InspIRCd on Linux, with an SSL certificate from Let's Encrypt. I think this guide would be useful since there aren't any good, up-to-date guides out there.</p>
    <p>The first time I connected the bot to my IRC server, the connection failed because it was using a self-signed SSL certificate. This was easy to fix by getting a free SSL certificate from Let's Encrypt for the web server running on irc.jamieweb.net, then setting up a script to automatically copy it daily to the IRC directory. The bot then connected without a problem because it was using a CA-signed certificate.</p>
    <p>I ran my IRC server for about a week, but in the end I decided to stop and switch back to using Freenode for the bot. There are a few reasons for this. Firstly, I asked on Reddit about the Freenode bot policy and found out that it is absolutely fine to run bots on Freenode. I don't know why Freenode doesn't have anything about this in their documentation/policies, perhaps they leave it out to discourage people. Secondly, security and practicality. InspIRCd is fantastic software and I trust its security, however since I can easily run my bot on Freenode, there is no need to run extra software, potentially opening more attack vectors. I was not using the IRC server for any actual chatting, it was just for the bot. There are also issues with installing/updating InspIRCd. Since the packaged version in the Ubuntu Universe repositories it very out of date (this is not the fault of the InspIRCd dev team), you have to manually compile. This isn't a massive problem, but it means that InspIRCd has to be updated manually, so I'd have to manually check daily for updates on the InspIRCd website, then apply them myself. This is an extra overhead that I don't really want for a piece of software used for only one purpose (the bot). If I was regularly chatting on the server, it would be absolutely fine to have this overhead.</p>
    <p>As I said above, the out of date packages in the Ubuntu/Debian repositories are not the fault of the InspIRCd dev team. It is the fault of the package maintainers. The InspIRCd dev team have spoken to them but apparently they do not seem interested in keeping them up to date. This is shocking, since having out of date, insecure packages in the main repositories is not good pracitse. A novice user may come along and install things from there, assuming that it is up to date. But really, they may be leaving themselves vulnerable. It is not just InspIRCd that suffers from this, the TOR packages are also also out of date in these repositories. I bet there are countless people using old TOR software because they simply didn't realise.</p>
    <h2>Conclusion</h2>
    <p>Overall, I do not think that I will take this project further due to the fact that I am unable to implement it in the way that I originally wanted, with full user-transparancy. If I were able to do this, I think that it would be a fantastic way to securely handle user inputs and other client-server communications. On a side note, I believe that it would be possible to do this with Flash, but that's just asking for trouble!</p>
    <p>As I said above, I am working on an in-depth guide for the installation and configuration of InspIRCd with Let's Encrypt SSL. I'll upload all of my configurations files in order to help other people set up the software. I'll publish this on my blog as soon as I am done, and will also edit this post and link it here. Thank you for reading!</p>
    <p>I have no affiliation with InspIRCd.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>