<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->title) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>This is a prelude to a multi-part series on BGP routing security:</p>
    <ul class="spaced-list">
        <li><b>Prelude:</b> Connecting to the DN42 Overlay Network (You Are Here)</li>
        <li><b>Part 1:</b> Coming Soon</li>
    </ul>
    <p>The purpose of this first article is to allow you to set up a suitible lab environment for practising BGP and the various routing security elements that are present in this guide.</p>
    <p>If you already have a lab environment set up, or are working on an existing BGP deployment, you can safely skip this prelude and go straight to Part 1.</p>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-dn42">What is DN42?</a>
&#x2523&#x2501&#x2501 <a href="#accessing-the-dn42-registry">Accessing the DN42 Registry</a>
&#x2523&#x2501&#x2501 <a href="#creating-registry-objects">Creating Registry Objects</a>
&#x2523&#x2501&#x2501 <a href="#merging-your-registry-objects-into-the-registry">Merging Your Registry Objects into the Registry</a>
&#x2523&#x2501&#x2501 <a href="#finding-a-peer">Finding a Peer</a>
&#x2523&#x2501&#x2501 <a href="#connecting-to-your-peer-using-openvpn">Connecting to Your Peer Using OpenVPN</a>
&#x2523&#x2501&#x2501 <a href="#dnsmasq-dns-setup-for-dn42-domains">Dnsmasq DNS Setup for '.dn42' Domains</a>
&#x2517&#x2501&#x2501 <a href="#part-1-conclusion">Part 1 / Conclusion</a></pre>

    <h2 id="what-is-dn42">What is DN42?</h2>
    <p><a href="https://en.wikipedia.org/wiki/Decentralized_network_42/" target="_blank" rel="noopener">Decentralized Network 42</a>, known as DN42, is a private overlay network built using thousands of distict nodes interconnected with eachother via VPN tunnels. DN42 employs routing protocols such as <a href="https://en.wikipedia.org/wiki/Border_Gateway_Protocol/" target="_blank" rel="noopener">BGP</a> and <a href="https://en.wikipedia.org/wiki/Open_Shortest_Path_First/">OSPF</a> in order to route packets, allowing users to deploy services such as websites, IRC servers and DNS servers in a way very similar to the real internet.</p>
    <img class="radius-8" width="1000px" src="dn42-landing-page.png">
    <p class="two-no-mar centertext"><i>The landing page for DN42, available at <a href="https://dn42.us/" target="_blank" rel="noopener">dn42.us</a>.</i></p>
    <p>The DN42 network is primarily used by network and security engineers in order to provide a safe and accessible environment to practise using network technologies, as well as allowing isolated networks, such as those behind strict firewalls or NAT, to communicate with eachother directly.</p>
    <p>However, the primary selling-point for DN42 is that it provides free and realistic access to a production-like BGP environment, which is something usually reserved for network operators responsible for large enterprise networks or ISPs who are also often paying expensive registry fees.</p>
    <img class="radius-8" width="1000px" src="dn42-wiki.png">
    <p class="two-no-mar centertext"><i>The DN42 wiki homepage, available at <a href="https://wiki.dn42.us/" target="_blank" rel="noopener">wiki.dn42.us</a>.</i></p>
    <p>This article will guide you through the process of registering and connecting to DN42, which is the equivalent of physically 'plugging yourself in' to the network. This won't yet let you communicate with the DN42 network fully, but it'll provide the foundation to begin BGP peering and announcing your IP address ranges to other members of the network.</p>
    <p>While it is possible to connect to DN42 using a physical router, the most common setup is to use a standard Linux server. Any modern Linux distribution should be suitible, however in this article I am focusing on Debian-based systems such as Ubuntu Server. macOS and Windows systems are also supported if you really want them to be, however for optimal compatibility and ease of configuration, I would strongly recommend using a Linux distribution designed for use on servers.</p>

    <h2 id="accessing-the-dn42-registry">Accessing the DN42 Registry</h2>
    <p>The DN42 registry is a central database containing all of the users of the network, the <a href="https://en.wikipedia.org/wiki/Autonomous_system_(Internet)/" target="_blank" rel="noopener">Autonomous Systems</a> (ASs) that they maintain and the IP address ranges assigned to them.</p>
    <p>This is equivalent to a <a href="https://en.wikipedia.org/wiki/Regional_internet_registry/" target="_blank" rel="noopener">Regional Internet Registry</a> (RIR), such as <a href="https://www.ripe.net/" target="_blank" rel="noopener">RIPE</a> (Europe), <a href="https://www.arin.net/" target="_blank" rel="noopener">ARIN</a> (North America) or <a href="https://www.apnic.net/" target="_blank" rel="noopener">APNIC</a> (Asia Pacific).</p>
    <p>DN42's registry is stored and operated as a Git repository, with a group of moderators responsible for reviewing and approving change requests.</p>
    <img class="radius-8" width="1000px" src="registry.png">
    <p class="two-no-mar centertext"><i>The DN42 registry, which can be accessed at <a href="https://git.dn42.us/dn42/registry" target="_blank" rel="noopener">git.dn42.us/dn42/registry</a>.</i></p>
    <p>In order to join DN42, you'll need to download a copy of the registry, add your information and configuration values to it (known as 'registry objects'), and then submit a change request back to the main registry.</p>
    <p>Begin by <a href="https://git.dn42.us/user/sign_up/" target="_blank" rel="noopener">signing up to the Git frontend for the registry</a>. Please note that <b>the email address that you use will be shared publicly</b>. If you're concerned about this, I recomend creating a new alias on your domain, such as <code>dn42@example.com</code> or <code>bgp@example.com</code>.</p>
    <p>Once you've signed up, navigate to the <a href="https://git.dn42.us/dn42/registry/" target="_blank" rel="noopener">repository for the main DN42 registry</a> and create a fork of it by clicking the 'Fork' button. This will create a copy of the repository within your own registry account.</p>
    <img class="radius-8" width="1000px" src="registry-forked.png">
    <p class="two-no-mar centertext"><i>An example of a forked copy of the DN42 registry.</i></p>
    <p>Next, you'll need to add an SSH public key to your registry account in order to allow you to authenticte to it using Git over SSH from the command-line. I recommend creating a new SSH key pair for this, which can be done using the following command:</p>
    <pre>$ ssh-keygen -t rsa -b 4096</pre>
    <p>Once you've generated the SSH key pair, add the public key to your registry account via your account settings, in the same way that you would add an SSH key to your GitHub/GitLab account.</p>
    <img class="radius-8" width="1000px" src="registry-add-ssh-key.png">
    <p class="two-no-mar centertext"><i>Successfully adding an SSH key to my DN42 registry account.</i></p>
    <p>Each user of DN42 should sign each of their change requests using a GPG key or SSH key in order to help prevent other users from submitting malicious change requests to the registry on their behalf. The key that you use when initially creating your registry objects will need to be used to sign all future change requests in order to validate your identity, otherwise they will not be accepted by the DN42 registry moderators.</p>
    <p>In this article we will focus on the usage of GPG, as it is the most widely used option. If you don't already have a GPG key suitible for use, you can create one using the following command:</p>
    <pre>$ gpg2 --full-generate-key</pre>
    <p>Select option #1 (rsa and rsa), and choose a suitible expiration date for the key. It may take quite some time to source enough entropy to properly generate your private key, so continue using your computer normally until it completes.</p>
    <p>Once your key has been successfully generated, identify its full key ID by listing all of your keys:</p>
    <pre>$ gpg2 --list-keys</pre>
    <p>Find your new key in the list and take a note of the full key ID, as shown in red in the example below:</p>
    <pre>pub   rsa4096 2019-10-19 [SC] [expires: 2020-10-18]
      <span class="color-red">AB72FE12526F44B611B99F7C24B1FB13F1B3B06C</span>
uid           [ultimate] Bob &lt;bob@example.com&gt;
sub   rsa4096 2019-10-19 [E] [expires: 2020-10-18]</pre>
    <p>Next, you'll need to submit your key to the public key servers, in order to allow the DN42 community to download your full key, just based on the key ID:</p>
    <pre>$ gpg2 --keyserver hkp://keyserver.ubuntu.com --send-keys <span class="color-red">your-key-fingerprint-here</span></pre>
    <p>Your key will appear on the <a href="https://keyserver.ubuntu.com/" target="_blank" rel="noopener">Ubuntu Keyserver</a> straight away, but may take a couple of hours to sync to the other key servers.</p>
    <p>Before proceeding, take a secure backup of your GPG key, as losing access to it could potentially mean losing access to your DN42 resources too.</p>
    <p>Now that you've got your SSH and GPG keys, you can proceed with connecting to the registry over SSH in order to make sure that everything is working.</p>
    <p>In order to make sure that SSH uses the correct private key for the connection, you may wish to add the following to the bottom of your <code>~/.ssh/config</code> file:
    <pre>host git.dn42.us
  IdentityFile ~/.ssh/<span class="color-red">your-ssh-private-key</span></pre>
    <p>You can now proceed with connecting to the registry, using the <code>-T</code> option to prevent a terminal session from being created:</p>
    <pre>$ ssh -T git@git.dn42.us</pre>
    <p>Since this is your first time connecting, you'll be asked whether you want to accept the server host key fingeprint or not. Modern SSH clients should display the ECDSA SHA256 fingerprint, as shown below in red:</p>
    <pre>The authenticity of host 'git.dn42.us (2607:5300:60:3d95::1)' can't be established.
ECDSA key fingerprint is SHA256:<span class="color-red">NxZ5DJlVKTdS8Kv0Dcyew76iAKDAp5K7QmWUM7gLZS8</span>.
Are you sure you want to continue connecting (yes/no)?</pre>
    <p>Double check that the fingerprint matches, and then proceed with connecting.</p>
    <p>Once you have connected successfully, the help page for Gogs should be printed (Gogs is the Git frontend used for the DN42 registry):</p>
    <pre>NAME:
  Gogs - A painless self-hosted Git service
 
USAGE:
  gogs [global options] command [command options] [arguments...]
 
VERSION:
  0.11.86.0130</pre>
    <p>The SSH session should terminate straight after printing the above help text, but if not, press Ctrl+C or Ctrl+D to forcefully close it.</p>
    <p>Now that you've successfully tested your SSH connection to the registry Git frontend, you can proceed with cloning your fork of the registry repository:</p>
    <pre>$ git clone git@git.dn42.us:<span class="color-red">your-registry-username-here</span>/registry.git</pre>
    <p>This will create a complete local copy of the DN42 registry. You can freely browse the directory structure and view all of the files, as well as make your own local changes ready to be submitted back to main repository.</p>
    <p>You should also configure Git to use your GPG key and enable forced commit signing, which can be done by running the following commands from within the <code>registry</code> directory:</p>
    <pre>$ git config user.signingkey <span class="color-red">your-key-fingerprint-here</span>
$ git config commit.gpgsign true</pre>
    <p>Finally, you should update your Git name and email address to match the details used to sign up to the registry. These details will be present on each commit that you make, so ensure that you're happy for them to be shared publicly:</p>
    <pre>$ git config user.name "<span class="color-red">your-name</span>"
$ git config user.email "<span class="color-red">your-dn42-email-address</span>"</pre>
    <p>You have now signed up to the DN42 registry, created the required cryptographic keys, downloaded a forked copy of the registry and configured your local Git environment. Next, you can begin to create registry objects to define the Autonomous Systems, IP address ranges and domain names that you want to register.</p>

    <h2 id="creating-registry-objects">Creating Registry Objects</h2>
    <p>The structure of the DN42 registry very closely matches that of an <a href="https://en.wikipedia.org/wiki/Internet_Routing_Registry/" target="_blank" rel="noopener">Internet Routing Registry</a> (IRR) on the real internet, such as RIPE. <a href="https://en.wikipedia.org/wiki/Routing-Policy_Specification_Language/" target="_blank" rel="noopener">Routing Policy Specification Language</a> (RPSL) is used to define objects (data) within a registry, such as IP address assignments, Autonomous System (AS) numbers, maintainership permissions and personal contact details. Data submitted to a registry is shared publicly, which allows networks around the world to correctly route traffic and identify organisations responsible for different parts of the wider internet</p>
    <p>In order to register your own network on DN42, you'll need to create a series of objects within your downloaded copy of the registry, which are stored as standard plaintext configuration files. You can do this using whichever method you find easiest, e.g. using a terminal session with <code>nano</code> or <code>vim</code>, or using a GUI file manager and text editor.</p>

    <h3 id="person-object">Person Object</h3>
    <p>Firstly, you'll need to create a 'person' object, which is essentially a file containing your own personal details. You should specify your name, public contact email address, as well as the PGP fingerprint of the key that you have configured for use with the registry. You can also optionally specify the address of your website.</p>
    <p>Your <a href="https://en.wikipedia.org/wiki/NIC_handle/" target="_blank" rel="noopener">NIC handle</a> (Network Information Centre handle) is a unique alphanumeric string used to identify you within the registry database, usually suffixed by the name of the registry that you're a part of, in this case <code>-DN42</code>. You can use any name that you want for this, including your real name or an online pseudonym, for example <code>JOEBLOGGS-DN42</code> or <code>NETWORKUSER1234-DN42</code>. Check the contents of the <code>/data/person</code> directory to make sure that the string you want to use hasn't already been taken by someone else.</p>
    <p>Proceed by creating an empty text file within the <code>/data/person</code> directory of the registry. The name of your 'person' object should match your NIC handle. Below is a copy of my own 'person' object, which should help you to understand the required format and layout of registry object files.</p>
    <p class="two-mar-bottom"><b>/data/person/JAMIEWEB-DN42</b>:</p>
    <pre class="two-mar-top">person:             Jamie Scaife
contact:            bgp@jamieweb.net
www:                https://www.jamieweb.net/
pgp-fingerprint:    9F23651633635B68EC10122232920E2ACC4B075D
nic-hdl:            JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>
    <p>Note that the second column always starts at character 21 on each line, i.e. there are 20 characters padded by spaces before it on each line.</p>
    <p>The <code>source</code> parameter refers to the authoritative registry that the route object is registered to (always DN42 in this case). The <code>mnt-by</code> parameter will be covered in the next section.</p>

    <h3 id="maintainer-object">Maintainer Object</h3>
    <p>Next, you'll need to create a 'maintainer' object, which is used to specify credentials that are permitted to create, modify or delete registry objects under your maintainership.</p>
    <p>Each registry object that you create will refer back to your maintainer object, helping to ensure that unauthorised changes cannot be made to your registry objects, as well as to make sure that every registry object has a properly assigned owner.</p>
    <p>Different methods exist for specifying authentication information, however in most cases within DN42's registry, a PGP key fingerprint is used. Some other registries, such as RIPE, implement their own single sign-on system for authentication and authorisation. Historically, some registries allowed you to specify the MD5 hash of a password within your maintainer object, which is a process that has luckily been mostly phased out by now.</p>
    <p>Below is a copy of my own maintainer object, which will help you to understand and populate the required fields. Make sure to update the PGP fingerprint to your own.</p>
    <p class="two-mar-bottom"><b>/data/mntner/JAMIEWEB-MNT</b>:</p>
    <pre class="two-mar-top">mntner:             JAMIEWEB-MNT
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
source:             DN42
auth:               pgp-fingerprint 9F23651633635B68EC10122232920E2ACC4B075D</pre>
    <p>You may recognise the <code>admin-c</code> and <code>tech-c</code> configuration parameters from domain name WHOIS records. These are used to specify the administrative and technical contacts for your maintainer object, which in the case of DN42, should usually refer back to your own 'person' object.</p>

    <h3 id="autonomous-system-number">Autonomous System (AS) Number</h3>
    <p>An Autonomous System refers to a collection of IP address range assignments that belong to a single administrative entity, such as a business or individual. Each AS has an AS number (ASN), which is used to uniquely identify it within internet routing policies.</p>
    <p>You can find the AS that you're a part of using the <a href="https://bgp.he.net/" target="_blank" rel="noopener">Hurricane Electric BGP toolkit</a>. You'll most likely see the AS of your ISP or upstream network provider, such as BT, Comcast, Telstra, etc.</p>
    <p>You can register your own ASN at a RIR, however the prerequisites and costs are often prohibitive for individuals or small businesses. For example, you may have to provide evidence of having contracts in place with upstream network providers, or have to be sponsored by an existing member of the RIR.</p>
    <p>Luckily within DN42, you can freely register an ASN for use within the network. Unfortunately it isn't usable outside of DN42, but the technical concepts for managing it are very similar.</p>
    <p>DN42 currently allocates ASNs from the range <code>AS4242420000</code> to <code>AS4242423999</code>. My own AS number on DN42 is <code>AS4242420171</code>.</p>
    <p>Begin by <a href="https://git.dn42.us/dn42/registry/src/master/data/aut-num/" target="_blank" rel="noopener">searching through the DN42 registry</a> to identify an unclaimed ASN. Most of the ASNs towards the start of the allowed range have already been taken, so you may wish to start looking half way down the list.</p>
    <p>Once you have identified an unclaimed ASN, proceed with creating an object in the registry for it, using my example below for guidance.</p>
    <p class="two-mar-bottom"><b>/data/aut-num/AS4242420171</b>:</p>
    <pre class="two-mar-top">aut-num:            AS4242420171
as-name:            JAMIEWEB-AS
descr:              JamieWeb AS
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>
    <p>The <code>as-name</code> and <code>descr</code> parameters can be used to add a human-readable name and description to your AS. Also notice how you are referring back to your person and maintainer objects with the <code>admin-c</code>, <code>tech-c</code> and <code>mnt-by</code> parameters.</p>

    <h3 id="ipv4-address-range-assignment">IPv4 Address Range Assignment</h3>
    <p>Now that you've claimed an ASN, you can proceed to allocate and assign an IPv4 address range for your use on DN42. Like on the real internet, IPv4 addresses on DN42 are in short supply, so you'll only be able to claim a small prefix as an individual. You'll be able to get a large IPv6 address range though, which is covered in the next step.</p>
    <p>DN42 uses the following private IPv4 address ranges:</p>
    <ul class="spaced-list">
        <li><code>172.20.0.0/14</code> - DN42 Main Network</li>
        <li><code>172.20.0.0/24</code> - Anycast Network</li>
        <li><code>172.21.0.0/24</code> - Anycast Network</li>
        <li><code>172.22.0.0/24</code> - Anycast Network</li>
        <li><code>172.23.0.0/24</code> - Anycast Network</li>
    </ul>
    <p>The anycast network is used to operate core DN42 network services such as the root DNS servers, where any DN42 member is able to anycast announce the relevant IP addresses and host their own root DNS server for use by the community.</p>
    <p>Like when assigning an ASN, you'll need to search through the registry in order to identify an unclaimed IPv4 address range. To make things a bit easier, you can use the <a href="https://dn42.us/peers/free/" target="_blank" rel="noopener">IPv4 open netblocks</a> page to see a list of unclaimed prefixes.</p>
    <img class="radius-8" width="1000px" src="ipv4-open-netblocks.png">
    <p class="two-no-mar centertext"><i>A list of open IPv4 netblocks on DN42, accessible at <a href="https://dn42.us/peers/free/" target="_blank" rel="noopener">dn42.us/peers/free</a>.</i></p>
    <p>Once you have found a suitable IPv4 address range, you can create the registry object for it, using the example of my own IPv4 range for reference:</p>
    <p class="two-mar-bottom"><b>/data/inetnum/172.20.32.96_28</b>:</p>
    <pre class="two-mar-top">inetnum:            172.20.32.96 - 172.20.32.111
cidr:               172.20.32.96/28
netname:            JAMIEWEB-V4-NET-1
country:            GB
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
status:             ASSIGNED
source:             DN42</pre>
    <p>You'll need to specify the exact IP address range within the <code>inetnum</code> configuration value, so make sure to double-check your subnet calculation where necessary.</p>
    <p>In order to actually announce your IPv4 address range, you must create a 'route' object, which is used to specify which AS is permitted to announce the prefix.</p>
    <p>In many cases this will be your own AS, however if you want someone else, such as a network operator, to announce the prefix on your behalf, you'll need to specify their ASN here. Delegating the permission to announce a particular prefix like this allows you to more safely utilise the services of third-party network operators, whilst still retaining full legal ownership of your prefixes.</p>
    <p>Proceed with creating the route object as required, using my own as an example:</p>
    <p class="two-mar-bottom"><b>/data/route/172.20.32.96_28</b>:</p>
    <pre class="two-mar-top">route:              172.20.32.96/28
origin:             AS4242420171
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>

    <h3 id="ipv6-address-range-assignment">IPv6 Address Range Assignment</h3>
    <p></p>
    <p class="two-mar-bottom"><b>/data/inet6num/fd5c:d982:d80d:9243::_64</b>:</p>
    <pre class="two-mar-top">inet6num:           fd5c:d982:d80d:9243:0000:0000:0000:0000 - fd5c:d982:d80d:9243:ffff:ffff:ffff:ffff
cidr:               fd5c:d982:d80d:9243::/64
netname:            JAMIEWEB-V6-NET-1
country:            GB
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
status:             ASSIGNED
source:             DN42</pre>

    <p class="two-mar-bottom"><b>/data/route6/fd5c:d982:d80d:9243::_64</b>:</p>
    <pre class="two-mar-top">route6:             fd5c:d982:d80d:9243::/64
origin:             AS4242420171
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>

    <h3 id="dn42-domain-name-registration"><code>.dn42</code> Domain Name Registration</h3>
    <p></p>
    <p class="two-mar-bottom"><b>/data/dns/jamieweb.dn42</b>:</p>
    <pre class="two-mar-top">domain:             jamieweb.dn42
descr:              JamieWeb
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
nserver:            ns1.jamieweb.dn42 172.20.32.97
nserver:            ns1.jamieweb.dn42 fd5c:d982:d80d:9243::2
source:             DN42</pre>

    <h2 id="merging-your-registry-objects-into-the-registry">Merging Your Registry Objects into the Registry</h2>
    <p></p>

    <h2 id="finding-a-peer">Finding a Peer</h2>
    <p></p>

    <h2 id="connecting-to-your-peer-using-openvpn">Connecting to Your Peer Using OpenVPN</h2>
    <p></p>

    <h2 id="dnsmasq-dns-setup-for-dn42-domains">Dnsmasq DNS Setup for '.dn42' Domains</h2>
    <p></p>

    <div class="message-box message-box-positive/warning/warning-medium/notice">
        <div class="message-box-heading">
            <h3><u></u></h3>
        </div>
        <div class="message-box-body">
            <p></p>
        </div>
    </div>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>