<?php 
   /*Check that this file is being accessed by the template*/
   if (!isset($in_template))
   {
   header( 'Location: /index.php/404');
   return;
   }
   $pagetitle="Download";
 ?>
<?php printTOC(); ?>
<p>
  DynamO is an open-source and free code, made available under version
  3 of the GPL licence. On this page you
  can <a href="#source-code-downloads">download the source code</a> so
  you can compile DynamO yourself or, if you have Ubuntu linux, you
  can use the <a href="#ubuntu">prebuilt packages</a>.
</p>
<h1>Ubuntu</h1>
<p>
  DynamO is now extremely easy to install on Ubuntu. Although you can
  download individual packages by hand, the recommended installation
  method is to add the PPA (Personal Package Archive) to your system
  so that you will recieve automatic updates whenever they are
  released.
</p>
<h2>Stable Releases</h2>
<p>
  To add the stable DynamO PPA to your system just open a terminal
  and run the following commands:
</p>
<?php codeblockstart(); ?>sudo add-apt-repository ppa:dynamomd/stable
sudo apt-get update<?php codeblockend("brush: shell;"); ?>
<p>
  One the PPA has been added, you can install DynamO, the tools, and
  the visualiser using the standard software manager or the following
  shell command:
</p>
<?php codeblockstart(); ?>sudo apt-get install dynamo-core dynamo-tools dynamo-visualisation<?php codeblockend("brush: shell;"); ?>
<h2>Nightly Development Releases</h2>
<p>
  There is a daily build of the DynamO development tree which you can
  use to get the cutting-edge features, but be warned, these builds
  may be unstable. 
</p>
<p>
  To add the development packages, add the development PPA to your
  system.
</p>
<?php codeblockstart(); ?>sudo add-apt-repository ppa:dynamomd/dynamo-daily-ppa
sudo apt-get update<?php codeblockend("brush: shell;"); ?>
<p>
  <b> Warning!</b>  If the development PPA is installed, it will
  override the stable PPA.
</p>
<h1>Source Code Downloads</h1>
<p>
  There are several ways you can obtain a copy of the source code and
  these are listed below.  Once you have a copy of the source code you
  can compile DynamO by
  <a href="/index.php/tutorial1">following the tutorial</a>.
</p>
<h2>Git Access to the Source</h2> 
<p>
  The recommended method of downloading an up-to-date copy of the
  DynamO sources is using git and
  the <a href="https://github.com/toastedcrumpets/DynamO"> public
  GitHub repository</a>. Using git, it is easy to update your version
  of the code and to send any changes you make back to the developers.
  To get a copy of the code, just install git and use the following
  command in your terminal:
</p> 
<?php codeblockstart(); ?>git clone http://github.com/toastedcrumpets/DynamO.git<?php codeblockend("brush: shell;"); ?>
<p>
  This will create a folder called <em>DynamO</em> in the working
  directory. If this command fails (you have a restrictive proxy), you
  can try the alternative git protocol address using the command
  below:
</p>
<?php codeblockstart(); ?>git clone git://github.com/toastedcrumpets/DynamO.git<?php codeblockend("brush: shell;"); ?>
<p>
  You can now pick which branch or version of DynamO you'd like. There
  are several available:
</p>
<ul>
    <li>
      <b>dynamo-1-4-0:</b> This is the most recent stable release, the
      code is as stable as possible and has been thoroughly tested for
      bugs, but it may miss recently added features.
    </li>
    <li>
      <b>master:</b> This is the stable development branch for the
      next release of DynamO, code <i>should</i> compile and run
      without errors but it may be a little buggy.
    </li>
    <li>
      <b>experimental:</b> This is where new patches and features are
      born. Probably unstable and buggy, but very fresh! Not really
      meant for the public, but its been made available to let others
      track or join in the development process.
    </li>
</ul>
<p>
  If you decide you want something other than the default branch
  (master), just check it out by running the following command in the
  DynamO directory:
</p>
<?php codeblockstart(); ?>git checkout dynamo-1-4-0<?php codeblockend("brush: shell;"); ?>
<p>
  Now that you've downloaded the source code, you can follow the tutorial on how to compile DynamO:
</p>
<?php button("Tutorial 1: Compiling DynamO from Source","/index.php/tutorial1");?>
<h2>Alternative Source Code Downloads</h2>
<p>
  It is recommended that you use the git to download the source code
  whenever possible. However, incase there is any problem accessing
  git on your computer, you may download a copy of the sources using
  one of the links below.
</p>
<?php button("Download Latest Development Branch","https://github.com/toastedcrumpets/DynamO/zipball/master");?>
<?php button("Download Stable Version 1.4.0","https://github.com/toastedcrumpets/DynamO/zipball/dynamo-1-4-0");?>