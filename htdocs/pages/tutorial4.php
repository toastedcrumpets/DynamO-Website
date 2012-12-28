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
<h2>About Square-Well Fluids</h2>
<p>
  For the purpose of the tutorial, we'll want to simulate a mixture of
  of square-well molecules. A square-well molecule is a particle which
  has a hard-core diameter of $\sigma$ and is surrounded by an
  attractive well with a diameter of $\lambda\,\sigma$ and a depth of
  $\varepsilon$. These variables are illustrated in the diagram below:
</p>
<img src="/images/sw.png" alt="A diagram of a square-well molecule including its parameters" width="650" height="232" style="display:block;margin:0 auto 0 auto;">
<p>
  where $u(r)$ is the interparticle potential (which is the potential
  energy between two particles separated by a distance of $r$).
<p>
  Square-well molecules are simple models which display the two
  fundamental features of real molecules, a short range repulsion (due
  to overlapping electron clouds) and longer ranged attraction (due to
  van-der-waals/london/dispersion forces). For example, when two
  distant square-well particles approach a distance of
  $r=\lambda\,\sigma$, they enter the well and a momentum impulse
  increases their kinetic energy by $\varepsilon$ (they are attracted
  to each other). If they then hit the inner core at a distance of
  $r=\sigma$ they will then be repulsed and will bounce off it. Once
  they begin to retreat from each other and again reach a distance of
  $r=\lambda\,\sigma$ they must have enough kinetic energy to escape
  the well and pay the energy cost, $\varepsilon$, otherwise they will
  bounce off the inside of the well.
</p>
<h2>The System Studied</h2>
<p>
  We're going to study a binary mixture of square-well
  molecules. We'll have a larger species, A, and a smaller species,
  B. The mixture we will study has a hard-core diameter ratio of
  $\sigma_A/\sigma_B=10$ and a mass ratio proportional to their
  volumes $m_A/m_B=\sigma_A^3/\sigma_B^3=1000$. Both molecules have
  the same well-width factor $\lambda_A=\lambda_B=1.5$. We'll want to
  study a mixture of $N=4000$ particles over a range of densities and
  concentrations.
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
  We see that square-well fluids can be made using <b>dynamod</b>'s
  packing mode 1. We can get some more information on this mode using
  the following command:
</p>
<?php codeblockstart(); ?>dynamod -m 1 --help<?php codeblockend("brush: shell;"); ?>
<p>
  And a detailed description of the modes options will be outputted on
  screen:
</p>
<?php codeblockstart(); ?>...
Mode 1: Mono/Multi-component square wells
 Options
  -C [ --NCells ] arg (=7)    Set the default number of lattice unit-cells in each direction.
  -x [ --xcell ] arg          Number of unit-cells in the x dimension.
  -y [ --ycell ] arg          Number of unit-cells in the y dimension.
  -z [ --zcell ] arg          Number of unit-cells in the z dimension.
  --rectangular-box           Set the simulation box to be rectangular so that the x,y,z cells also specify the simulation aspect ratio.
  -d [ --density ] arg (=0.5) System density.
  --i1 arg (=FCC)             Lattice type (0=FCC, 1=BCC, 2=SC)
  --f1 arg (=1.5)             Well width factor (also known as lambda)
  --f2 arg (=1)               Well Depth (negative values create square shoulders)
  --s1 arg (monocomponent)    Instead of f1 and f2, you can specify a multicomponent system using this option. You need to pass the the parameters for each species as follows --s1 "diameter(d),lambda(l),mass(m),welldepth(e),molefrac(x):d,l,m,e,x[:...]"
...<?php codeblockend("brush: shell;"); ?>
<p>
  This mode can create a multicomponent system for us using the first
  string option (<i>--s1</i>), but we'll create it by hand from the
  monocomponent system.
</p>
<p>
  Lets make a starting configuration of
</p>
<h1>Compressing the Configuration</h1>
<h1>Running the Simulation</h1>
<h1>Processing the Results</h1>
