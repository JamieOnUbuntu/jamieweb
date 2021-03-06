<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <div class="centertext">
        <img class="max-width-100-percent-on-small padding-bottom-30-on-small" width="495px" src="ut-lock-screen.png">
        <img class="max-width-100-percent-on-small" width="495px" src="ut-home-screen.png">
    </div>
    <p>In this article, I have documented the installation process using the ubports-installer application, and included a manual bug fix that is currently required for installation on some MX4 phones. This fix was kindly put together by <a href="https://forums.ubports.com/user/alainw94" target="_blank" rel="noopener">AlainW94</a> on the UBports forum, and documented here with their permission.</p>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#standard-installation-procedure">Standard Installation Procedure</a>
&#x2523&#x2501&#x2501 <a href="#fixing-the-failed-remote-unknown-command-error">Fixing the <code>FAILED (remote: unknown command)</code> Error</a>
&#x2523&#x2501&#x2501 <a href="#using-ubuntu-touch-on-the-meizu-mx4-in-2019">Using Ubuntu Touch on the Meizu MX4 in 2019</a>
&#x2517&#x2501&#x2501 <a href="#things-i-d-like-to-see">Things I'd Like to See</a></pre>

    <h2 id="standard-installation-procedure">Standard Installation Procedure</h2>
    <div class="message-box message-box-notice">
        <div class="message-box-heading">
            <h3><u>Notice:</u></h3>
        </div>
        <div class="message-box-body">
            <p>There is currently a bug in ubports-installer affecting some Meizu devices, preventing the installation from succeeding. It may be worth <a href="#fixing-the-failed-remote-unknown-command-error">reading ahead</a> so you know what to look out for. The fix involves making a manual code change and recompiling the application.</p>
        </div>
    </div>
    <p>The official method for installing Ubuntu Touch is using the ubports-installer application, which can be installed from the <a href="https://snapcraft.io/ubports-installer" target="_blank" rel="noopener">Snap Store</a>:</p>
    <pre>$ snap install ubports-installer</pre>
    <p>Other installation methods are also available, if you'd prefer. Please see the repository on GitHub: <a href="https://github.com/ubports/ubports-installer" target="_blank" rel="noopener">https://github.com/ubports/ubports-installer</a></p>
    <p>I recommend running ubports-installer using the <code>ubports-installer</code> command, rather than using the desktop/menu shortcut, as seeing the verbose log output can be very useful for debugging errors and ensuring that everything is working properly.</p>
    <img class="radius-8" src="ubports-installer-1-welcome-screen.png" width="1000px" alt="A screenshot of the UBports installer application, showing the main welcome screen.">
    <p>The welcome screen will try to auto-detect your phone if it is plugged in. For me, this unfortunately didn't work, so I selected it manually.</p>
    <p>Then, you can select your desired installation options:</p>
    <img class="radius-8" src="ubports-installer-2-select-install-options.png" width="1000px" alt="A screenshot of the UBports installer application, showing my phone selected and the 'Install Options' menu.">
    <p>The latest version at the time of writing is Ubuntu Touch 16.04.</p>
    <img class="radius-8" src="ubports-installer-3-ready-to-install.png" width="1000px" alt="A screenshot of the UBports installer application, showing the installation confirmation screen.">
    <p>Then, you'll need to put your phone in Fastboot mode, by holding down the power and volume down buttons while your device is in a powered-off state. You may have to hold them for a while, as in some cases it can take up to 30 seconds. This also doesn't seem to work reliably while your device is plugged in via USB, so I suggest temporarily disconnecting it while you do this.</p>
    <img class="radius-8" src="ubports-installer-4-please-reboot-to-bootloader.png" width="1000px" alt="A screenshot of the UBports installer application, asking the user to reboot their phone into the bootloader, with a static graphic demonstrating how to do this.">
    <p>After you've done this, the installation should begin properly. However, on some Meizu devices you will run into the <code>FAILED (remote: unknown command)</code> error. If this is the case, then this is a known bug. The temporary fix involves making a minor code change and recompiling ubports-installer - I have documented the entire process <a href="#fixing-the-failed-remote-unknown-command-error">below</a>.</p>
    <p>If you encounter another error, it may be that you don't have permission to access your device over USB. You should add the following rules to <code>/etc/udev/rules.d/51-meizu.rules</code> (or another name of your choice), and ensure that your Linux user account is in the <code>plugdev</code> group:</p>
    <pre>SUBSYSTEM=="usb", ATTRS{idVendor}=="0bb4", MODE="0666", GROUP="plugdev"
SUBSYSTEM=="usb", ATTRS{idVendor}=="2a45", MODE="0666", GROUP="plugdev"</pre>
    <p>...then restart udev by running <code>udevadm control --reload-rules</code> followed by <code>udevadm trigger</code> as root.</p>
    <p>If your installation is working successfully, you'll see the following screen:</p>
    <img class="radius-8" src="ubports-installer-5-pushing-files-to-device.png" width="1000px" alt="A screenshot of the UBports installer application, showing the installation running successfully with a 'Pushing files to device...' notice.">
    <p>Installation takes around 5 minutes, and then there is another stage of installation that takes place on the phone itself. This also takes around 5 minutes.</p>
    <p>Your phone will reboot, and you can begin using Ubuntu Touch!</p>

    <h2 id="fixing-the-failed-remote-unknown-command-error">Fixing the <code>FAILED (remote: unknown command)</code> Error</h2>
    <p>At the time of writing, there is a known bug in ubports-installer affecting some Meizu devices. Essentially, the installer tries to reboot the phone into recovery mode, but Meizu phones don't fully support this, so you have to put it into recovery mode manually by holding the power button and volume up.</p>
    <p>If you're affected by this, you'll see the following error both in the GUI and terminal output of ubports-installer:</p>
    <pre>debug: fastboot: flash; [{"type":"recovery","url":"http://cdimage.ubports.com/devices/recovery-arale.img","checksum":"27160d1ce2d55bd940b38ebf643018b33e0516795dff179942129943fabdc3d8","path":"/home/j/snap/ubports-installer/183/.cache/ubports/images/arale"}]
info: Booting into recovery image...
error: Devices: Error: Fastboot: Unknown error:  downloading 'boot.img'...
OKAY [  0.702s]
booting...
FAILED (remote: unknown command)
finished. total time: 0.716s</pre>
    <p>Unfortunately the error handling in ubports-installer doesn't allow you to bypass this error by manually rebooting into recovery mode. As a temporary fix, you can manually remove the offending error handling code and recompile the application.</p>
    <div class="message-box message-box-positive">
        <div class="message-box-heading">
            <h3><u>Thank You to AlainW94 on the UBports Forum</u></h3>
        </div>
        <div class="message-box-body">
            <p>I'd like to give a massive thanks to <a href="https://forums.ubports.com/user/alainw94" target="_blank" rel="noopener">AlainW94</a> on the UBports Forum for devising this solution and assisting with my problem in my <a href="https://forums.ubports.com/topic/2492/mx4-ubuntu-edition-failed-remote-unknown-command" target="_blank" rel="noopener">forum thread</a>. They provide a lot of valuable support and contributions to UBports, so I am very grateful for their help!</p>
        </div>
    </div>
    <p>In order to implement the workaround, you'll need to download a copy of the ubports-installer source code:</p>
    <pre>$ git clone https://github.com/ubports/ubports-installer.git</pre>
    <p><code>cd</code> into the downloaded repository, and open the <code>src/devices.js</code> in your text editor.</p>
    <p>Next, scroll down to the following section:</p>
    <pre>                 // If we can't find it, report error!
                  if (!recoveryImg){
                    bootstrapEvent.emit("error", "Cannot find recoveryImg to boot: "+images);
                  }else {
                    fastboot.boot(recoveryImg, p, (err, errM) => {
                      if (err) {
                        handleBootstrapError(err, errM, bootstrapEvent, () => {
                          instructBootstrap(fastbootboot, images, bootstrapEvent);
                        });
                      }else
                        bootstrapEvent.emit("bootstrap:done", fastbootboot);
                    })
                  }</pre>
    <p>Then, comment out the error handling code, and replace it with the contents of the corresponding <code>else</code> condition. I've marked the modified lines below with <code>**</code>:</p>
    <pre>                 // If we can't find it, report error!
                  if (!recoveryImg){
                    bootstrapEvent.emit("error", "Cannot find recoveryImg to boot: "+images);
                  }else {
                    fastboot.boot(recoveryImg, p, (err, errM) => {
                      if (err) {
**                      bootstrapEvent.emit("bootstrap:done", fastbootboot);
**                      //handleBootstrapError(err, errM, bootstrapEvent, () => {
**                      //  instructBootstrap(fastbootboot, images, bootstrapEvent);
**                      //});
                      }else
                        bootstrapEvent.emit("bootstrap:done", fastbootboot);
                    })
                  }</pre>
    <p>Once you've saved this change, you need to compile the application. To do this on Ubuntu 18.04, you'll need the <code>npm</code> and <code>libgconf2-4</code> packages. You can also just run <code>setup-dev.sh</code> which should set up your build environment for you.</p>
    <p>Next, run <code>npm run-script dist:linux</code> (or <code>dist:mac</code>/<code>dist:win</code>, for whichever your platform is).</p>
    <p>Finally, you can run the application with <code>npm start</code>. Now, ubports-installer will bypass errors at the point where the phone is required to be booted into recovery mode. This should allow you to proceed with the installation by manually putting your phone into recovery (hold power + volume up) when it prompts you to.</p>
    <p>This is of course not a perfect solution, as anything that involves bypassing error handling code is generally a bad idea, but as a temporary solution is does the job.</p>

    <h2 id="using-ubuntu-touch-on-the-meizu-mx4-in-2019">Using Ubuntu Touch on the Meizu MX4 in 2019</h2>
    <p>On my Meizu MX4, Ubuntu Touch performs well, and the battery lasts a long time. The OS has all of the features required for general smartphone usage, especially the way that many technical/security-oriented people use their phone. However, if you are a big social media/app user, then you may have issues due to the lack of official apps for most platforms.</p>
    <p>Ubuntu Touch is ideal for privacy and security conscious users, as well as those who like the convenience of having a fully capable native Linux device in their pocket. The fact that there is a native and unrestricted Linux terminal is also brilliant!</p>
    <div class="centertext">
        <img class="max-width-100-percent-on-small padding-bottom-30-on-small" width="495px" src="ut-file-explorer.png">
        <img class="max-width-100-percent-on-small" width="495px" src="ut-terminal.png">
    </div>

    <h2 id="things-i-d-like-to-see">Things I'd Like to See</h2>
    <p>There are a few things that I'd really like to see in Ubuntu Touch, so I thought I'd document them here:</p>
    <ul class="spaced-list">
        <li>Ability to use the phone without physical buttons (e.g. tap/swipe to wake, lock with on-screen button) - this is to preserve the physical buttons, which tend to be the first things to break on phones after a lot of use</li>
        <li>Auto power-on and auto power-off</li>
        <li>Quick access to the camera from the lock screen</li>
        <li>Support for a 6 digit unlock code, rather than 4</li>
        <li>More accessibility features</li>
    </ul>
</div>

<?php include "footer.php" ?>
