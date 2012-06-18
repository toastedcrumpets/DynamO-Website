<?php 
   /*Check that this file is being accessed by the template*/
   $mathjax=1;
   if (!isset($in_template))
   {
   header( 'Location: /index.php/404');
   return;
   }
   $pagetitle="Tutorial 3: Exploring the Configuration File Format";
   ?>
<p style="text-align:center; border: 5px solid; background-color:#FFD800; font-size:16pt; font-family:sans; line-height:40px;">
  <b>This tutorial is currently being written.</b>
</p>
<p>
  In this tutorial we'll start to explore the file format of DynamO
  and look at ways of setting up arbitrary simulations.
</p>
<h1>1. Introduction</h1>
<p>
  When studying a new system, we need to find a convenient way to
  generate sample configurations generated across the range of study
  parameters that we wish to simulate.
</p>
<p>
  Many sample configurations, with variable input parameters, can be
  generated using the dynamod tool; However, these example setups only
  cover systems studied by the DynamO developers and will sometimes
  not exactly coincide with the wishes of the DynamO user.
</p>
<p>
  The recommended method for performing simulations with DynamO is to
  use dynamod to generate a configuration close to what you wish to
  simulate. This configuration can then be modified to produce the
  exact system you wish to study. These changes can easily be
  automated to reduce the manual effort
  required (<a href="/index.php/tutorialA">See Appendix A</a> for
  more information).
</p>
<p>
  So in order to effectively use DynamO, we must have a good
  understanding of it's configuration file format.
</p>
<h1>2. The Starting Configuration</h1>
<div class="figure" style="float:right;width:400px;">
  <div class="video-container" style="width:400px;">
    <video controls poster="/videos/hardspheres.jpg" preload="none">
      <source src="/videos/hardspheres.mp4" type='video/mp4' />
      <source src="/videos/hardspheres.ogg" type='video/ogg' />
      <iframe width="400" height="250" src="https://www.youtube-nocookie.com/embed/tn6Cz0tNPuU"></iframe>
    </video>
  </div>
  <div class="caption">
    The starting configuration of 1372 hard-spheres with periodic
    boundary conditions.
  </div>
</div>
<p>
  We will generate a standard hard sphere configuration and use it to
  explore the file format. We will also demonstrate the effect of some
  simple changes as well.  We have chosen to look at the hard sphere
  configuration as it is one of the simplest configurations we can
  generate.
</p>
<p>
  To begin, use dynamod to generate a hard sphere configuration like
  so:
</p>
<?php codeblockstart(); ?>
dynamod -m 0 -d 0.5 -C 7 -o config.start.xml
<?php codeblockend("brush: shell;"); ?>
<p>
  Some example output is provided at the button below for
  convenience. Note that your own generated output will have different
  randomly-assigned-velocities than the example provided.
</p>
<?php button("Example Configuration File","/pages/config.tut3.xml");?>
<p>
  XML files can be opened and edited by your favourite text editor. If
  you click the link above you will see that modern web browsers will
  present the contents of an XML file nicely, but you won't be able to
  edit them.
</p>
<h1>3. The Tags</h1>
<p>
  Open the XML file and take a look at the top of the file. You'll
  notice that there is a short line at the top that identifies this
  file as an XML file:
</p>
<?php codeblockstart(); ?>
<?xml version="1.0"?>
<?php codeblockend("brush: xml;"); ?>
<p>
  Underneath this is the contents of the file. You will notice that
  the whole content of the file is enclosed within a pair
  of <b>DynamOconfig</b> <i>tags</i>. In XML, these are called
  the <i>root tags</i>:
</p>
<?php codeblockstart(); ?>
<DynamOconfig version="1.5.0">
...
</DynamOconfig>
<?php codeblockend("brush: xml;"); ?>
<p>
  Whenever some content has been omitted we will use "..." to indicate
  the XML data we have skipped. There is
  a <b>version</b> <i>attribute</i> in
  the <b>DynamOconfig</b> <i>tag</i> which is used by DynamO to check
  that the file format is the up-to-date version before trying to load
  it. This version number is only incremented whenever a breaking
  change is needed.
</p>
<h2>Particle Data</h2>
<p>
  We'll start with the particle data first as it makes up the bulk of
  the data contained in the file. At the bottom of the file, you
  should see lots of <b>Pt</b> <i>tags</i> stored inside
  a <b>ParticleData</b> <i>tag</i>:
</p>
<?php codeblockstart(); ?>
<DynamOconfig version="1.5.0">
  ...
  <ParticleData>
    <Pt ID="0">
      <P x="-6.50000000000000e+00" y="-6.50000000000000e+00" z="-6.50000000000000e+00"/>
      <V x="-5.52389513657453e-01" y="-1.50017672465470e-01" z="-2.80144593124301e-01"/>
    </Pt>
    ...
  </ParticleData>
</DynamOconfig>
<?php codeblockend("brush: xml;"); ?>
<p>
  Each of these <b>Pt</b> <i>tags</i> represent the data of a single
  particle.  Each <b>Pt</b> <i>tag</i> has
  an <b>ID</b> <i>attribute</i>, which is a unique number used to help
  you identify the particle. <u>This ID number is not read by
  DynamO</u>. DynamO loads and assigns ID's to the particles in the
  order they appear in the configuration file. It is just written
  there for your reference to show you the ID numbers DynamO last
  used.
</p>
<p>
  Inside the particle (<b>Pt</b>) <i>tag</i> there are two
  enclosed <i>tags</i> called <b>P</b>
  and <b>V</b>. The <b>P</b> <i>tag</i> holds the position of a
  particle within the system and the <b>V</b> tag holds the particles
  velocity.
</p>
<p>
  You may notice and wonder that there is no mass or size of the
  particles specified here. This is because of the very general and
  unique functional definition of "properties" of particles possible
  in DynamO. The mass of a particle is defined by <b>Species</b> tags,
  and its interaction properties, such as its diameter, is specified
  in the <b>Interaction</b> tags. We'll start to explore these
  Simulation settings in the following sections.
</p>
<h2>Scheduler</h2>
<p>
  At the top of the file, the actual dynamics of the simulation are
  specified. These are all contained within a <b>Simulation</b>
  tag. The first tags are the <b>Scheduler</b> tags (please ignore the
  ensemble tags for now, they will be removed in a future version).
</p>
<?php codeblockstart(); ?>
<DynamOconfig version="1.5.0">
  ...
  <Scheduler Type="NeighbourList">
    <Sorter Type="BoundedPQMinMax3"/>
  </Scheduler>
  ...
</DynamOconfig>
<?php codeblockend("brush: xml;"); ?>
<p>
  The Scheduler tags contain the settings for the event scheduler and
  event sorter, which are the parts of DynamO responsible for
  determining which event happens next in the simulation. 
</p>
<p>
  Changing the scheduler settings should never affect the results
  DynamO generates, but a correct set of settings will greatly
  increase DynamO's speed. The Scheduler tags will almost always look
  as they do above, as these are the optimal settings for most simple
  systems.
</p>
<h2>Simulation Settings</h2>
<p>
  In the <b>Simulation</b> <i>tag</i> there is another <i>tag</i>
  called <b>SimulationSize</b>. Unsurprisingly, this holds the size of
  the simulation domain.
</p>
<?php codeblockstart(); ?>
<DynamOconfig version="1.5.0">
  ...
  <SimulationSize x="1.400000000000e+01" y="1.400000000000e+01" z="1.400000000000e+01"/>
  ...
</DynamOconfig>
<?php codeblockend("brush: xml;"); ?>
<p>
  Here we can see the simulation is performed in a
  $14\times14\times14$ domain. We will see in a moment that this
  system has periodic boundary conditions, but even infinite systems
  must have some finite size specified for the neighbourlist to
  function, so you will always see a SimulationSize tag in your
  configurations.
</p>
<h2>Boundary Conditions</h2>
<p>
  Another mandatory tag within the Simulation tags is the Boundary
  Condition (<b>BC</b>) tag.
</p>
<?php codeblockstart(); ?>
<DynamOconfig version="1.5.0">
  ...
  <BC Type="PBC"/>
  ...
</DynamOconfig>
<?php codeblockend("brush: xml;"); ?>

<p>
  Here we can see that the current BCs are Periodic Boundary
  Conditions (<b>PBC</b>). If you change the boundary conditions
  to <b>None</b>, like so:
</p>
<?php codeblockstart(); ?>
...
<BC Type="None"/>
...
<?php codeblockend("brush: xml;"); ?>
<div class="figure" style="float:right;width:337px;">
  <iframe width="333" height="250" src="https://www.youtube-nocookie.com/embed/RzjmpRtwDAw"></iframe>
  <div class="caption">
    The same configuration as in the movie above, but with the
    Boundary Conditions set to <b>None</b>.
  </div>
</div>
<p>
  The configuration will now exist in an infinite domain without
  boundaries (see the video on the right). The particles will be
  allowed to fly off in all directions, which is very useful if you
  want to simulate a single polymer or any macroscopic piece of
  equipment.
</p>
<p>
  But be warned, if you now try to convert back to periodic boundary
  conditions, all particle positions will be "folded" back into the
  simulation domain specified by the <b>SimulationSize</b> tag (a
  cubic $14\times14\times14$ volume). This "folding" will probably
  result in overlapping particles leading to invalid dynamics, so you
  need to be careful when changing Boundary Conditions from None to
  PBC.
</p>
<p>
  There are also Lees-Edwards shearing boundary conditions available
  in DynamO (Type="LE") which will be discussed in a future tutorial.
</p>
<h2>Species</h2>
<h2>Interactions</h2>
<h2>Locals</h2>
<h2>Globals</h2>
<h2>Dynamics</h2>
<h2>Units</h2>
<p>
  A common question users ask when first using DynamO is "What are the
  units of Dynamo?" and the answer is "whichever units you use". 
</p>
