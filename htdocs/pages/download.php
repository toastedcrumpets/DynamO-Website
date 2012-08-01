<?php 
   /*Check that this file is being accessed by the template*/
   if (!isset($in_template))
   {
   header( 'Location: /index.php/404');
   return;
   }
   $pagetitle="Download";
 ?>
<p> 
  DynamO is an open-source and free code, made available under
  version 3 of the GPL licence. There are several ways you can obtain a
  copy of the source code and these are listed below.
</p>
<h1>Git Access to the Source</h1> 
<p>
  The recommended method of downloading an up-to-date copy of the
  DynamO sources is using git and
  the <a href="https://github.com/toastedcrumpets/DynamO"> public
  GitHub repository</a>.
</p>

<p>
  Just install git and use the following command in your terminal:
</p> 
<?php codeblockstart(); ?>git clone https://github.com/toastedcrumpets/DynamO.git<?php codeblockend("brush: shell;"); ?>
<p>
  This will create a folder called <em>DynamO</em> in the working
  directory. If this command fails, you can try the alternative git
  protocol address using the command below:
</p>
<?php codeblockstart(); ?>git clone git://github.com/toastedcrumpets/DynamO.git<?php codeblockend("brush: shell;"); ?>
<p>
  You can now pick which branch or version of DynamO you'd like. There
  are several available:
</p>
<ul>
    <li>
      <b>dynamo-1-3-2:</b> This is the most recent stable release, the
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
<?php codeblockstart(); ?>git checkout dynamo-1-3-2<?php codeblockend("brush: shell;"); ?>
<h1>Alternative Source Code Downloads</h1>
<p>
  It is recommended that you use the git to download the source code
  whenever possible. However, incase there is any problem accessing
  git on your computer, you may download a copy of the sources using
  the links below.
</p>
<?php button("Download Latest Development Branch","https://github.com/toastedcrumpets/DynamO/zipball/master");?>
<?php button("Download Stable Version 1.3.2","https://github.com/toastedcrumpets/DynamO/zipball/dynamo-1-3-2");?>
<?php button("Download Stable Version 1.2","https://github.com/toastedcrumpets/DynamO/zipball/dynamo-1-2");?>
