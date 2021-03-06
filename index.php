<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>JamieWeb</title>
    <meta name="description" content="Cyber security, open-source, software development and reverse engineering - the personal blog and website of Jamie Scaife.">
    <?php include "head.php" ?>
    <link href="/projects/computing-stats/" rel="ids-allow"><!--This is to help my IDS script pick up the dynamic content on the computing-stats page.-->
    <link href="https://www.jamieweb.net/" rel="canonical">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="body">
    <div class="content redlink">
        <h1>Jamie Scaife - United Kingdom &#x1f1ec;&#x1f1e7;&nbsp;<?php include "holiday-emojis.php"; ?></h1>
        <hr>
        <div class="recent-posts"><?php bloglist("home"); ?></div>
        <hr>
        <a href="/blog/">
            <div class="view-all-button centertext">
                <h3 class="no-mar-top no-mar-bottom">View All Posts</h3>
            </div>
        </a>
    </div>

    <div class="sidebar">
        <input type="radio" class="gravity-radio" id="identicon">
        <label class="gravity-label" for="identicon"></label>
        <!--Thanks to jdenticon.com for the identicon image generation!-->
        <!--My identicon seed is the sha256 hash of the plain text word "JamieOnUbuntu".-->
        <hr>
        <div class="centertext sideitems">
            <a href="https://gitlab.com/jamieweb" target="_blank" rel="noopener"><img src="/images/fontawesome/gl.svg"> <span><b>GitLab</b></span></a>
            <a href="https://twitter.com/jamieweb" target="_blank" rel="noopener"><img src="/images/fontawesome/tw.svg"> <span><b>Twitter</b></span></a>
            <a href="https://www.youtube.com/jamie90437x" target="_blank" rel="noopener"><img src="/images/fontawesome/yt.svg"> <span><b>YouTube</b></span></a>
            <a href="https://keybase.io/jamieweb" target="_blank" rel="noopener"><img src="/images/fontawesome/kb.svg"> <span><b>Keybase</b></span></a>
            <a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener"><img class="h1 exempt" src="/images/hackerone.png"> <span><b>HackerOne</b></span></a>
            <a href="https://news.ycombinator.com/user?id=jamieweb" target="_blank" rel="noopener"><img class="hn exempt" src="/images/fontawesome/hn.svg"> <span><b>Hacker News</b></span></a>
        </div>
        <hr>
        <h2 class="centertext two-mar-top two-mar-bottom">Subscribe</h2>
        <div class="centertext">
            <a class="icontext two-mar-top" href="/rss.xml" target="_blank"><img src="/images/fontawesome/rss-orange.svg"> <span><b>RSS Feed</b></span></a>
        </div>
        <hr>
        <h2 class="centertext">Popular Pages</h2>
        <div class="redlink tops">
            <a href="/projects/computing-stats/">
                <h4 class="no-mar-bottom">Raspberry Pi + BOINC Stats</h4>
                <h5 class="two-no-mar">Stats from my RPi cluster + BOINC.</h5>
                <p class="two-mar-top">Updated Every 10 Minutes</p>
            </a>
            <a href="/tools/exploitable-web-content-blocking-test/">
                <h4 class="no-mar-bottom">Exploitable Web Content Blocking Test</h4>
                <h5 class="two-no-mar">Test whether exploitable web content is blocked in your web browser.</h5>
            </a>
            <a href="/blog/onionv3-hidden-service/">
                <h4 class="no-mar-bottom">Tor Onion v3 Hidden Service</h4>
                <h5 class="two-no-mar">Testing the new Onion v3 Hidden Services.</h5>
                <p class="two-mar-top">Saturday 21st October 2017</p>
            </a>
            <a href="/blog/namecoin-bit-domain/">
                <h4 class="no-mar-bottom">Namecoin .bit Domain</h4>
                <h5 class="two-no-mar">Guide to registering a Namecoin .bit domain.</h5>
                <p class="two-mar-top">Tuesday 16th January 2018</p>
            </a>
        </div>
        <hr>
        <h2 class="centertext">Tor Hidden Services</h2>
        <div class="redlink">
            <p class="no-mar-top no-mar-bottom">My website is also available as a Tor Hidden Service.</p>
            <p class="two-mar-bottom display-inline-block">Onion v2: </p>
            <div class="onionlink two-mar-top">
                <p class="no-mar word-break-all"><a class="font-family-monospace" href="http://jamiewebgbelqfno.onion" target="_blank" rel="noopener">jamiewebgbelqfno.onion</a></p>
            </div>
            <p class="two-mar-bottom display-inline-block">Onion v3: </p>
            <div class="onionlink two-mar-top">
                <p class="no-mar word-break-all"><a class="font-family-monospace" href="http://jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion" target="_blank" rel="noopener">jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion</a></p>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</body>

</html>
