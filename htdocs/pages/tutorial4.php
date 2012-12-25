<?php 
   /*Check that this file is being accessed by the template*/
   $mathjax=1;
   if (!isset($in_template))
   {
   header( 'Location: /index.php/404');
   return;
   }
   $pagetitle="Tutorial 4: Example: Multicomponent Square-Well Fluid";
   ?>
<?php printTOC(); ?>
<p style="text-align:center; margin:15px; background-color:#FFD800; font-size:16pt; font-family:sans; line-height:40px;">
  <b>This tutorial is currently being written and is incomplete.</b>
</p>
<p>
  This tutorial uses an example study of multicomponent square-well
  particles to introduce several topics:
</p>
<ul>
  <li>
    How to use the example configurations generated by
    the <b>dynamod</b> command as a basis for more complex systems.
  </li>
  <li>
    How to specify multiple species and complex interactions in the
    configuration file.
  </li>
  <li>
    How to compress a simulation to higher densities.
  </li>
  <li>
    How to process collected data, including transport coefficients,
    in the output file.
  </li>
</ul>
<p>
  Although this tutorial looks at a multicomponent square-well fluid,
  it provides you with all of the knowledge you need to study any
  multicomponent system.
</p>
<h1>Setting up the Configuration File</h1>
<p>
  When you first start using DynamO, it is not really practical to try
  to create a configuration file from scratch. It is much simpler and
  convenient to take an existing configuration, which is close to the
  system you wish to study, and to modify it. Once you are familiar
  with the file format you may then write your own tools to generate
  configuration files in the programming language of your choice.
</p>
<p>
  We need to see what systems the <b>dynamod</b> command can prepare
  so that we can pick the most convenient starting point for the
  multicomponent square-well system. We again query the available
  options of the <b>dynamod</b> command using the <i>--help</i>
  option:
</p>
<?php codeblockstart(); ?>dynamod --help<?php codeblockend("brush: shell;"); ?>
<p>
  A full listing of the options of the <b>dynamod</b> program is
  outputted, and the start of the list of systems it can create/pack
  should look like the following:
</p>
<?php codeblockstart(); ?>...
Packer options:
  -m [ --pack-mode ] arg Chooses the system to pack (construct)
                         Packer Modes:
                         0:  Monocomponent hard spheres
                         1:  Mono/Multi-component square wells
                         2:  Random walk of an isolated attractive polymer
<?php codeblockend("brush: shell;"); ?>
<p>
  We see that square wells can be
</p>
<h1>Running the Simulation</h1>
<h1>Processing the Results</h1>
