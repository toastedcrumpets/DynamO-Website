<?php 
   $mathjax=1;
   /*Check that this file is being accessed by the template*/
   if (!isset($in_template))
   {
   header( 'Location: /index.php/404');
   return;
   }
   $pagetitle="Parsing Output and Config Files";
   $pagetab="Tutorial A";
   ?>
<?php printTOC(); ?>
<p>
  This appendix is designed to help people interface DynamO with other
  pieces of software, or to write tools to process the results of
  simulations. It demonstrates several ways in which you can parse the
  XML which makes up the configuration and output files, to either
  read out the data you want or to edit and change the configuration
  files.
</p>
<p style="text-align:center;">
  <b>This is not a tutorial on the format of the configuration or
  output files, but on <u>easy ways to read and edit these
  files.</u></b>
</p>
<p>
  The configuration file format itself is covered in more depth
  in <a href="/index.php/tutorial3">this tutorial</a> or in the
  <a href="/index.php/reference">reference</a>. The description of the
  output file format is available in
  the <a href="/index.php/outputplugins">documentation for the output
  plugins</a>. Before reading this appendix it would be best to
  already be familiar with how DynamO operates and have a good idea
  what information you'd like to extract.
</p>
<h1>Background on XML and XPath</h1>
<p>
  The file formats of DynamO are written in XML, which is a convenient
  markup language that is easy for both humans and computers to
  read. The main advantage of writing data in XML is that there are
  many excellent XML libraries and tools available out there to help
  you read the files using any programming language you like; However,
  there are some general concepts to first understand before you can
  use them.
</p>
<h2>XML Documents</h2>
<p>
  XML files consist of <b>tags</b> and <b>attributes</b>. Tags are a
  way of organising information and can contain information like so:
</p>
<?php codeblockstart(); ?>
<TagName>
  Some contained data, maybe some more XML tags.
</TagName>
<?php codeblockend("xml"); ?>
<p>
  or they can be self closing if they don't contain any tags/data:
</p>
<?php codeblockstart(); ?>
<TagName/>
<?php codeblockend("xml"); ?>
<p>
  Attributes are a way of attaching data to a tag. For example:
</p>
<?php codeblockstart(); ?>
<Pet Type="Cat" Name="Tom"/>
<Pet Type="Dog" Name="Fido"/>
<?php codeblockend("xml"); ?>
<p>
  With our data organised using XML, we need a simple way to select
  parts of it to read or edit it. The most convenient method of doing
  this is typically though <b>XPath</b> expressions.
</p>
<h2>XPath Expressions</h2>
<p>
  There is an excellent introduction to <b>XPath</b>
  expressions <a href="http://www.w3schools.com/xpath/default.asp">available
  here</a>, but we'll just quickly cover the basic usage now.
</p>
<p>
  We'll take an example XML file and discuss how to select different
  parts of it. In general, a DynamO output file will look something
  like this:
</p>
<?php codeblockstart(); echo "<?xml version=\"1.0\"?>\n"; ?>
<OutputData>
  <Misc>
    <Density val="0.5"/>
    <PackingFraction val="0.261799387799154"/>
    <SpeciesCount val="1"/>
    <ParticleCount val="1372"/>
    <Temperature Mean="1" MeanSqr="0.999999999999983" Current="1.00000000000001"/>
    <UConfigurational Mean="0" MeanSqr="0" Current="0"/>
    <ResidualHeatCapacity Value="0"/>
    <Pressure Avg="1.63675534410931">
      <Tensor>
	1.63579652003868 0.00150781121155836 -0.00219599326916204 
	0.00150781121155836 1.63761040787334 0.0014142402702099 
	-0.00219599326916205 0.0014142402702099 1.63685910441592 
      </Tensor>
    </Pressure>
    <Duration Events="1000000" OneParticleEvents="0" TwoParticleEvents="1000000" Time="189.547531133865"/>
    <Timing Start="Thu Jun 14 23:20:27 2012 " End="Thu Jun 14 23:20:32 2012 " EventsPerSec="197261.743069976" SimTimePerSec="37.3904782963859"/>
    <PrimaryImageSimulationSize x="14" y="14" z="14"/>
    <Total_momentum x="2.88657986402541e-14" y="3.99680288865056e-15" z="2.87214696470528e-13"/>
    <totMeanFreeTime val="0.130029606357831"/>
    <NegativeTimeEvents Count="0"/>
    <Memusage MaxKiloBytes="35404"/>
  </Misc>
</OutputData>
<?php codeblockend("xml"); ?>
<p>
  Let us say we wanted to read the number of events the simulation has
  run for. We can specify the Event attribute of the Duration tag
  using the following XPath expression:
</p>
<?php codeblockstart(); ?>
/OutputData/Misc/Duration/@Events
<?php codeblockend("xpath"); ?>
<p>
  This XPath expression selects the Event attribute by descending from
  the root tag (<b>OutputData</b>) all the way down to
  the <b>Duration</b> tag, then choosing its Events attribute. We can
  give this xpath expression to whatever XML tool or library we have
  and it will fetch the value of the Event attribute for us. But what
  if we want to search for our tag?
</p>
<p>
  We could write an XPath expression which searches for all Duration
  tags, and selects their Event attributes like so:
</p>
<?php codeblockstart(); ?>
//Duration/@Events
<?php codeblockend("xpath"); ?>
<p>
  Notice the double forward slash at the start? It means search
  through the whole document for the node called Duration, then try to
  match the rest of the XPath expression from that starting point. An
  important thing to note is that <b>all</b> Duration tags in the file
  are selected with this expression, but in this case there is only
  one.
</p>
<p>
  What if there are many tags all with the same name? How do we pick
  just one of them? Consider the truncated DynamO configuration file below:
</p>
<?php codeblockstart(); echo "<?xml version=\"1.0\"?>\n"; ?>
<DynamOconfig version="1.5.0">
  <Simulation>...</Simulation>
  <Properties/>
  <ParticleData>
    <Pt ID="0">
      <P x="-1.11037288097451e+01" y="-1.11037288097451e+01" z="-1.11037288097451e+01"/>
      <V x="-2.95244768899765e+00" y="1.69905035103138e+00" z="-4.36956213342932e-01"/>
    </Pt>
    <Pt ID="1">
      <P x="-9.39546283901511e+00" y="-9.39546283901511e+00" z="-1.11037288097451e+01"/>
      <V x="5.15945424590186e-01" y="5.70316794177150e-03" z="-1.20432656964027e+00"/>
    </Pt>
    <Pt ID="2">
      <P x="-1.11037288097451e+01" y="-9.39546283901511e+00" z="-9.39546283901511e+00"/>
      <V x="4.36297207983260e-01" y="5.85618104960393e-01" z="8.24344277363928e-01"/>
    </Pt>
    <Pt ID="3">
      <P x="-9.39546283901511e+00" y="-1.11037288097451e+01" z="-9.39546283901511e+00"/>
      <V x="3.79648279950273e-01" y="9.10688422856331e-01" z="-8.44297890125311e-01"/>
    </Pt>
    ...
  </ParticleData>
</DynamOconfig>
<?php codeblockend("xml"); ?>
<p>
  What if we wanted to select all the Pt (particle) tags so we can
  later read their P (position) tags? The following two expressions
  are equivalent and do exactly what we want:
</p>
<?php codeblockstart(); ?>
/DynamOconfig/ParticleData/Pt
//Pt
<?php codeblockend("xpath"); ?>
<p>
  So how do we select just one tag out of a whole list of tags? Well,
  the easiest way is to specify its number, like so:
</p>
<?php codeblockstart(); ?>
/DynamOconfig/ParticleData/Pt[1]
//Pt[1]
<?php codeblockend("xpath"); ?>
<p>
  Both of these expressions create a list of Pt tags, then select the
  first one to appear (in this case, the one with and ID attribute of
  0). But what if the tags are out of order and we want to search for
  a tag with a certain ID value? This is where the power of XPath
  expressions becomes apparent:
</p>
<?php codeblockstart(); ?>
//Pt[@ID="0"]
<?php codeblockend("xpath"); ?>
<p>
  Now we're searching for a Pt tag with an ID attribute value of
  0. These square bracket expressions are called predictates and they
  are extremely powerful. For example, we can select the last Pt tag
  using the following XPath expressions:
</p>
<?php codeblockstart(); ?>
//Pt[last()]
<?php codeblockend("xpath"); ?>
<p>
  Or we could select the P tags of all Pt tags with an ID below
  4 using the following XPath expressions:
</p>
<?php codeblockstart(); ?>
//Pt[@ID<4]/P
<?php codeblockend("xpath"); ?>
<p>
  There is a lot more to learn about XPath expressions, but we now
  know enough to access any data we would like to from the output and
  config files of DynamO.
</p>
<p>
  We will now cover some tools and libraries that let you apply XPath
  expressions to XML documents and to actually discuss some
  interesting examples of using them.
</p>
<h1>Using Python</h1>
<p>
  The most versatile way of processing collected data has to be with
  python. Many DynamO tools, such as <b>dynatransport</b>,
  <b>dynamo2xyz</b>, and <b>dynamaprmsd</b>, are written in Python as
  it is easy to use and has basic built in support for XML files. The
  basic library only supports a small part of the XPath standard, but
  there are several libraries available such as lxml if advanced XPath
  features are needed. Below, we will introduce a couple of example
  applications of Python and DynamO.
</p>
<h2>Example: Making an XYZ Position File</h2>
<p>
  The most common file format for handling atomic/particle systems is
  the XYZ format. This file format just lists the total number of
  particles and the positions (and sometimes velocities) of each
  particle. Below is a sample python script which loads a config file
  and prints to screen an XYZ-like list of data. Please note, you do
  not need to write your own code for this, it is just an example as
  DynamO already has a handy tool for creating XYZ files,
  called <b>dynamo2xyz</b>. This is written in python and the latest
  version
  is <a href="https://github.com/toastedcrumpets/DynamO/blob/master/src/dynamo/programs/dynamo2xyz">available
  here</a>.
</p>
<?php codeblockstart(); ?>
#!/usr/bin/python
import os
import xml.etree.ElementTree as ET
 
#A helpful function to load compressed or uncompressed XML files
def loadXMLFile(filename):
    #Check if the file is compressed or not, and 
    if (os.path.splitext(filename)[1][1:].strip() == "bz2"):
        import bz2
        f = bz2.BZ2File(filename)
        doc = ET.parse(f)
        f.close()
        return doc
    else:
        return ET.parse(filename)
 
#Load the XML file config.out.xml
XMLDoc=loadXMLFile("config.out.xml")
 
#We can create a list of all particle tags using an xpath expression
#(xpath expressions always return lists)
PtTags = XMLDoc.findall("//Pt")
 
#Print the number of particles
print len(PtTags)

#print the x, y, and z positions of each particle
for PtElement in PtTags:
    PosTag = PtElement.find("P")
    print PosTag.get("x"), PosTag.get("y"), PosTag.get("z")
<?php codeblockend("python"); ?>
<h2>Example: Creating a Povray file</h2>
<p>
  Sometimes you might want to prepare a very high quality image for
  publication or presentation at a conference. Povray is an excellent
  and free ray-tracing renderer, capable of producing stunning
  scenes. This example script converts a dynamo output file into a
  simple Povray file using the more-powerful <b>lxml</b> python
  library.
</p>
<?php codeblockstart(); ?>
#!/usr/bin/python
import os
import sys 
import xml.etree.ElementTree as ET
 
def loadXMLFile(filename):
    #Check if the file is compressed or not, and 
    if (os.path.splitext(filename)[1][1:].strip() == "bz2"):
        import bz2
        f = bz2.BZ2File(filename)
        doc = ET.parse(f)
        f.close()
        return doc
    else:
        return ET.parse(filename)

XMLDoc = loadXMLFile(sys.argv[1])
 
# Write the header for the Povray file
diameter = 1.0
print '#version 3.6 ;'
print '#include \"colors.inc\"'
print '#include \"transforms.inc\"'
print '#include \"glass.inc\"'
print 'global_settings { max_trace_level 20 }'
print 'global_settings { noise_generator 1 }'
print 'global_settings { ambient_light 2.5 }'
print 'global_settings { assumed_gamma 1.0 }'
print 'background { rgb<1, 1, 1> }'
print '#declare zoom = 10.4 ;'
print '#declare Cam0 ='
print '  camera {location  <-0.75*zoom , 0.75*zoom , zoom>'
print '           look_at   <0.05 , 0.1 , 0.0>}'
print 'camera{Cam0}'
print 'light_source{<-10,50,0> color White}'
print 'light_source{<10,30,30> color White}'
print '#declare particle = sphere {'
print ' <0,0,0>', diameter/2
print ' texture { pigment { color rgb<0.1,0.1,0.6> }}'
print '  finish { phong 0.9 phong_size 60 } }'
 
#Create a list of all particle position (P) tags
PtTags = XMLDoc.findall("//Pt/P")
 
#Loop over each particles position, outputting a povray object for it
for element in PtTags:
    print "object { particle translate <", element.get("x"),",", element.get("y"),",", element.get("z"),">}"
<?php codeblockend("python"); ?>
<h1>Using XMLStarlet (shell scripting)</h1>
<p>
  The easiest way to see the effect of XPath expressions on a DynamO
  configuration file is to use
  the <a href="http://xmlstar.sourceforge.net/"><b>xmlstarlet</b></a>
  tool. Its a compact and effective program for rapidly selecting some
  data out of an xml file, and if you are familar with shell scripting
  you will find it very easy to use.
</p>
<h2>Example: Making an XYZ Position File</h2>
<p>
  The best way to learn XMLstarlet is through examples. The first is
  how to generate a file with just the positions in it. This file
  format is very popular among the MD community. The way you would
  call xmlstarlet is as follows:
</p>
<?php codeblockstart(); ?>
xmlstarlet sel -t -m '//Pt/P' -v '@x' -o ' ' -v '@y' -o ' ' -v '@z' -n config.out.xml
<?php codeblockend("bash"); ?>
<p>
  Breaking this command down, it calls xmlstarlet, places it into
  select mode (sel). Then it starts a template (-t) which is a command
  or action for xmlstarlet to take. The instructions are then:
</p>
<ul>
  <li>
    <b>(-m '//Pt/P')</b> Search through the XML file for a P tag within a Pt tag, then:
    <ul>
      <li>
	<b>(-v '@x')</b> Write out the value of the x attribute.
      </li>
      <li>
	<b>(-o ' ')</b> Print a single space
      </li>
      <li>
	<b>(-v '@y')</b> Write out the value of the y attribute.
      </li>
      <li>
	<b>(-o ' ')</b> Print a single space
      </li>
      <li>
	<b>(-v '@z')</b> Write out the value of the z attribute.
      </li>
      <li>
	<b>(-n)</b> Print a new line.
      </li>
    </ul>
  </li>
</ul>
<p>
  You should use shell redirection if you want to send this output to
  a file (i.e., <b>xmlstarlet <i>options</i> > myfile.xyz</b>).
</p>
<h2>Example: Deleting Particles to make a sphere of spheres</h2>
<p>
  We will now show a nice feature of XPath expressions, which is the
  ability to do math!
</p>
<p>
  First, create a system of 1372 hard spheres using the following command:
</p>
<?php codeblockstart(); ?>dynamod -m 0 -C 7 -d 0.5 -o config.start.xml<?php codeblockend("bash"); ?>
<p>
  If you take a look inside the configuration, you'll see the system
  is a 14x14x14 periodic cube, and the particle positions lie in the
  range of $[\pm7,\pm7,\pm7]$.
</p>
<p>
  Lets say that we want to remove all particles whose centres lie
  outside of a sphere of radius 5, centered about the origin. We need
  an XPath expression to select all particle (Pt) tags, whose centers
  (P) lie outside of the sphere. This can be achieved easily using
  math in the predicate:
</p>
<?php codeblockstart(); ?>
//Pt[P/@x * P/@x + P/@y * P/@y + P/@z * P/@z  > 25.0]
<?php codeblockend("xpath"); ?>
<p>
  We have used the square of the radius as the condition
  ($R^2=5^2=25$) as XPath does not support complex math functions such
  as square root, and we use the following identity
</p>
$$\begin{align*}
\left|\mathbf{P}\right| &amp;> R\\
P_x^2+P_y^2+P_z^2 &amp;> R^2
\end{align*}$$
<p>
  To use this XPath expression to delete the nodes, we simply run
  XMLstarlet using its edit (ed) mode, and apply a delete (-d) action
  as follows:
</p>
<?php codeblockstart(); ?>cat config.start.xml | xmlstarlet ed -d '//Pt[P/@x * P/@x + P/@y * P/@y + P/@z * P/@z  > 25.0]' > config.trimmed.xml<?php codeblockend("bash"); ?>
<div style="text-align:center;">
  <?php embedfigure("/images/tutA_cubetosphere.png", 450, 209, "A
    demonstration of the effect of the XPath expression in creating a
    rough sphere of particles.");?>
</div>
<p>
  We can take a look at the difference between config.start.xml and
  config.trimmed.xml using the visualiser and see the results above.
</p>
<p>
  If you want to create or edit XML files in great detail, I highly
  recommend that you switch from using XMLStarlet to using an XML
  library in the programming language of your choice (like python),
  but XMLStarlet is a great way to get started.
</p>
