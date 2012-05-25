<?php
  global $syntaxhighlighter;
  $syntaxhighlighter=1;
  pagestart("Tutorial 2: Running a Simulation of Hard Spheres"); 
?>
<div style="float:right; width:50%; max-width:500px">
  <div class="video-container" style="padding-bottom: 62.5%;" >
    <video controls >
      <source src="/videos/hardspheres.mp4" type='video/mp4' />
      <source src="/videos/hardspheres.ogg" type='video/ogg' />
      <iframe width="266" height="160" src="https://www.youtube-nocookie.com/embed/tn6Cz0tNPuU" allowfullscreen frameborder="0"></iframe>
    </video>
  </div>
</div>
<p>
  In this tutorial, we will cover the basics of using DynamO, and
  learn how to simulate the simplest event driven system, the hard
  sphere fluid with periodic boundary conditions.
</p>
<p>
  A video of this system and what is covered in this tutorial is
  presented to the right.  At first, the hard spheres are shown in
  their initial configuration generated by the <b>dynamod</b>
  tool. 1372 particles are placed on a regular FCC lattice and
  assigned random velocities.
</p>
<p>
  Once the simulation is started (using the <b>dynarun</b> program),
  the lattice structure rapidly disappears. However, it is obvious
  from the still-quite-clear color banding that the particles have not
  moved very far. The system still has a memory of its initial
  configuration and we will need to equilibrate the system before we
  collect data.
</p>
<p>
  To equilibrate the system, the simulation is then set to run at full
  speed for a few thousand collisions and then slowed down again to
  take a look at the results. We can see that the simulation has
  equilibrated well and the colored particles are well mixed.
</p>
<p>
  Let's take a look at how to perform this simulation in DynamO...
</p>
<h1>1. Verifying your DynamO Installation</h1>
<p>
  Please ensure that you have already followed
  the <a href="/index.php/tutorial1">previous tutorial</a> and
  compiled and installed your own copy of DynamO.
</p>
<p>
  We'll start off by testing if you successfully compiled and
  installed DynamO. Open up a terminal and run the following command:
</p>
<pre class="brush: shell; ">dynamod</pre>
<p>
  You may need to change this path to wherever you installed the
  dynamo binaries. If everything is working correctly, you should see
  the copyright notice and the descriptions of the options of the
  dynamod program:
</p>
<script type="syntaxhighlighter" class="brush: plain"><![CDATA[
dynamod  Copyright (C) 2011  Marcus N Campbell Bannerman
This program comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. See the licence you obtained with
the code
Usage : dynamod <OPTIONS>...[CONFIG FILE]
....]]></script>
<p>
  If you do not see the above output, please double check that you
  encountered no errors when building dynamo. Return to
  the <a href="/index.php/tutorial1">previous tutorial</a> and recheck
  the output of the <b>make</b> command.
</p>
<p>
  We're now ready to run our first simulation.
</p>
<h1>2. In Brief</h1> 
<p>
  Lets quickly cover the content of this tutorial now, and afterwards
  we'll go into the detail of each step. Let us say that you want to
  run a hard-sphere simulation of 1372 particles at a reduced density
  of 0.5 and a temperature of 1.
</p>
<p>
  You want to create the system, and then run it for 10<sup>6</sup>
  collisions to equilibrate, then another 10<sup>6</sup> collisions to
  collect some data for your research. All you have to do is run the
  following commands in your terminal/shell:
</p>
<pre class="brush: shell; ">#Create the configuration
dynamod -m 0 -C 7 -d 0.5 -r 1 -o config.start.xml

#A "equilibration run" to equilibrate the configuration
dynarun config.start.xml -c 1000000 -o config.equilibrated.xml

#A "production run" to collect data on the system
dynarun config.equilibrated.xml -c 1000000 -o config.end.xml</pre>
<p>
  But what were those three commands and what do the options/switches
  (-c -o -m) control? We'll look at each command individually in the
  following sections.
</p>
<h1>2. Configuration files and dynamod</h1>
<p>
  The first step in the brief example was to create the
  initial <b>configuration file</b>, called <em>config.start.xml</em>,
  using <b>dynamod</b>.
</p>
<pre class="brush: shell; ">dynamod -m 0 -C 7 -d 0.5 -r 1 -o config.start.xml</pre>
<p>
 In this section,
  we will learn about the configuration files of DynamO, which are the
  main input and output of DynamO, and how to generate configuration
  files using <b>dynamod</b>.
</p>
<h2>2.1. About the configuration file</h2>
<p>
  Before we can run any simulations with DynamO, we must write or
  generate a configuration file. A configuration file is a single file
  which contains all of the parameters of the system.
</p>
<p>
  The configuration file format is used for:
</p>
<ul>
  <li>
    The starting point for a simulation.
  </li>
  <li>
    For saving any snapshots of the system while it is being simulated.
  </li>
  <li>
    For saving the final state of the simulation for continuing it later. 
  </li>
</ul>
<p>
  Every single parameter of the system is set in this one
  configuration file, including the particle positions, interactions,
  boundary conditions and solver details. Many other simulation
  packages usually place some of this information in several different
  files, but DynamO only uses one file. Lets take a look at this
  file...
</p>
<h2 >2.2. Generating an example configuration file</h2>
<p>
  To take a closer look at the configuration file format of DynamO, we
  need to generate an example file. To do this we can use
  the <b>dynamod</b> program.
</p>
<p>
  <b>dynamod</b> is a program designed to manipulate existing
  configuration files or to generate example configuration files. We
  can take a look at the options of <b>dynamod</b> using
  the <em>--help</em> option:
</p>
<pre class="brush: shell; ">dynamod --help</pre>
<p>
  There are many options available and most are related to modifying
  existing configurations (this is why it is called dyna<b>mod</b>),
  but if we want to generate a configuration we are only need to be
  interested in the section starting with
</p>
<pre class="brush: shell; ">
...
Packer options:
  -m [ --packer-mode ] arg    Chooses the system to pack (construct)
                              Packer Modes:
                              0:  Monocomponent hard spheres
                              1:  Mono/Multi-component square wells
                              2:  Random walk of an isolated attractive polymer
...
</pre>
<p>
  We can ask <b>dynamod</b> to generate any one of the configurations
  listed there using the <em>--packer-mode</em> option (or <em>-m</em>
  for short). As this is a tutorial on hard spheres, we should
  probably use mode 0:
</p>
<pre class="brush: shell">dynamod -m 0 -o hardsphere.xml</pre>
<p>
  This writes a configuration file corresponding to the default
  hard-sphere system to a file called <em>hardsphere.xml</em>. But how
  do you control the density, or size and temperature of the system?
</p>
<pre class="brush: shell">dynamod -m 0 --help</pre>
<p>
  However, for now we will just use the default settings.
</p>
<h2>2.3. Exploring the configuration file</h2>
<p>
  Lets take a look inside the <em>hardsphere.xml</em> file we just
  generated. You can open this <b>XML file</b> with your favourite
  text editor, or even your web browser. XML files are a modern way
  for storing data and are used in a wide range of applications as
  they're easy for both a human and a computer to understand. If you
  have trouble understanding the general XML format,
  please <a href="http://www.w3schools.com/xml/">take a look at these
  tutorials</a>.
</p>
<p>
  The whole configuration is enclosed within a pair
  of <b>DynamOconfig</b> <em>tags</em>.
</p>
<script type="syntaxhighlighter" class="brush: xml"><![CDATA[
<?xml version="1.0"?>
<DynamOconfig version="1.4.0">
...
</DynamOconfig>
]]></script>
<p>
  We will omit these tags in the following examples and use "..." to
  indicate any XML data we have skipped.
</p>
<p>
  We'll start with the particle data first. At the bottom of the file,
  you should see lots of <b>Pt</b> <em>tags</em> stored inside
  a <b>ParticleData</b> <em>tag</em>:
</p>
<script type="syntaxhighlighter" class="brush: xml"><![CDATA[
<ParticleData>
...
<Pt ID="56">
<P x="-6.50000000000000e+00" y="-2.50000000000000e+00" z="-6.50000000000000e+00"/>
<V x="5.20851366504843e-01" y="-5.38736236641469e-01" z="-1.56915668716473e+00"/>
</Pt>
...
</ParticleData>
]]></script>
<p>
  Each of these <b>Pt</b> <em>tags</em> represent the data of a single
  particle.
</p>
<p>
  Each <b>Pt</b> tag has an <b>ID</b> <em>attribute</em>, which is a
  unique number used to identify the particle, and two
  enclosed <em>tags</em> called <b>P</b>
  and <b>V</b>. The <b>P</b> <em>tag</em> holds the position of a
  particle within the system and the <b>V</b> tag holds the particles
  velocity.
</p>
<p>
  At the top of the file, the actual dynamics of the simulation are
  specified. For example, in the <b>Simulation</b> <em>tag</em> there
  is another <em>tag</em>
  called <b>SimulationSize</b>. Unsurprisingly, this holds the size of
  the simulation domain.
</p>
<script type="syntaxhighlighter" class="brush: xml"><![CDATA[
<SimulationSize x="1.400000000000e+01" y="1.400000000000e+01" z="1.400000000000e+01"/>
]]></script>
<p>
  There are many other <em>tags</em> in the configuration file. For
  example, the <b>BC</b> <em>tag</em> sets the boundary conditions of
  the simulation. The type may be <b>"PBC"</b> for periodic boundary
  conditions or <b>"None"</b> for an infinite system.
</p>
<p>
  If you want to simulate a certain system, it is recommended you take
  the nearest system available in dynamod, then look at other examples
  to understand how to add whatever else you might require. But for
  now, we will just use this starting configuration to run a
  simulation and collect snapshots of the system.
</p>
<h1>3. Running a simulation</h1>
<p>
  Now that we have a configuration, we are ready to run a simulation!
  This is very easy, just run <b>dynarun</b> like so:
</p>
<pre class="brush: shell">dynarun hardsphere.xml -o hardsphere.final.xml -c 1000000</pre>
<p>
  This will use <b>dynarun</b> to calculate the trajectory of
  the <em>hardsphere.xml</em> configuration for a million events
  (<em>-c 1000000</em>) and then write the final configuration
  to <em>hardsphere.final.xml</em>. If you want to run a simulation
  for a certain time (instead of a certain number of events) you just
  run <b>dynarun</b> with the <em>-f</em> option:
</p>
<pre class="brush: shell">dynarun hardsphere.xml -o hardsphere.final.xml -f 200</pre>
<p>
  and this will use <b>dynarun</b> to calculate the trajectory of the
  hardsphere.xml configuration for 200 units of simulation time.
</p>
<p>
  There are many ways to collect data from a DynamO simulation, but
  the most common usage is to take periodic snapshots of the
  system. DynamO has a special command line option for this:
</p>
<pre class="brush: shell">dynarun hardsphere.xml -o hardsphere.final.xml -f 200 --snapshot 20</pre>
<p>
  This will take a snapshot of the system every 20 units of simulation
  time! If you run the command above, you will see you have 10
  snapshots taken:
</p>
<pre class="brush: shell">ls Snapshot.* 
  Snapshot.0.xml.bz2 Snapshot.1.xml.bz2 Snapshot.2.xml.bz2
  Snapshot.3.xml.bz2 Snapshot.4.xml.bz2 Snapshot.5.xml.bz2
  Snapshot.6.xml.bz2 Snapshot.7.xml.bz2 Snapshot.8.xml.bz2
  Snapshot.9.xml.bz2</pre>
<p>
  Congratulations, you've run your first DynamO simulation!
</p>
<?php pageend(); ?>
