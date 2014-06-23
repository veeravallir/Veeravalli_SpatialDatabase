### Assignment 5 - GIS File Types (and other stuff) 
### Ramakrishna Veeravalli 


~~~
File Extensions

~~~

1. SHP file :

The shapefile is in fact a grouping of several files formatted to represent different aspects of geodata: .shp — shape format; the feature geometry itself. .shx — shape index format; a positional index of the feature geometry to allow seeking forwards and backwards quickly. .dbf — attribute format; columnar attributes for each shape, in dBase IV format.

2. OSM File :

OpenStreetMap data files are traditionally distributed in an XML format representing the node, way, and relation concepts using a simple schema. Without compression, this XML format can be extremely large, so it is usually distributed using an efficient compression algorithm like gzip or bz2. Most of the tools designed to work with the OSM XML data format can also handle the compressed XML.

3. GeoJSON FIle :

GeoJSON is a format for encoding a variety of geographic data structures. A GeoJSON object may represent a geometry, a feature, or a collection of features. GeoJSON supports the following geometry types: Point, LineString, Polygon, MultiPoint, MultiLineString, MultiPolygon, and GeometryCollection. Features in GeoJSON contain a geometry object and additional properties, and a feature collection represents a list of features.

4. GPX :

GPX (the GPS Exchange Format) is a light-weight XML data format for the interchange of GPS data (waypoints, routes, and tracks) between applications and Web services on the Internet.

OGR has support for GPX reading (if GDAL is build with expat library support) and writing.

5. KML :

Keyhole Markup Language (KML) is an XML-based markup language designed to annotate and overlay visualizations on various two-dimensional, Web-based online maps or three-dimensional Earth browsers (such as Google Earth). In fact, KML was initially developed for use with Google Earth;

6. NMEA :

Your GPS receiver might output or record your tracks in NMEA format, this is a format that can easily be converted to GPX so you can upload it to our website. Even though GPX is preferred there are still several OpenStreetMap tools that support NMEA including new versions of JOSM.

7. CSV :

A CSV file is commonly described as a ‘Comma Delimited File’ or a ‘Character Separated File’. The second description is more accurate since any character including the comma, can be used to delineate each piece of data. For example, a TSV file, ‘commonly known as a ‘Tab Delimited File’, is really just a special case of a CSV file. Since a CSV file is a simple text file (ASCII or Unicode) it can be easily opened by Notepad.exe which is included in all versions of MS Windows.

8. WKT  : 

Well-known text (WKT) is a text markup language for representing vector geometry objects on a map, spatial reference systems of spatial objects and transformations between spatial reference systems. A binary equivalent, known as well-known binary (WKB) is used to transfer and store the same information on databases, such as PostGIS, Microsoft SQL Server and DB2.


~~~
Software

~~~


1. ArcGIS  : 

ArcGIS is  the Professional GIS Authoring Application
ArcGIS helps you use spatial information to perform deep analysis, gain a greater understanding of your data,
and make more informed decisions. 

2. QGIS : 

A Free and Open Source Geographic Information System.
QGIS (previously known as "Quantum GIS") is a cross-platform free and open source desktop 
geographic information systems (GIS) application that provides data viewing, editing, and analysis capabilities.

3. GPSBabel : 

GPSBabel is a cross-platform, free software to transfer routes, tracks, and waypoint data to and from consumer GPS units, 
and to convert between over a hundred types of GPS data formats. It has a command-line interface and a graphical interface 
for Windows, OS X, and Linux users.



4. GDAL   : 

Geospatial Data Abstraction Library
GDAL is a translator library for raster and vector geospatial data formats that is released under an X/MIT style Open Source license by the Open Source Geospatial Foundation. As a library, it presents a single raster abstract data model and vector abstract data model to the calling application for all supported formats. It also comes with a variety of useful commandline utilities for data translation and processing.







~~~

Definitions  

~~~




1. Point  :  

A Point is a geometry that represents a single location in coordinate space.
 
 
2. Curve   :

A Curve is a one-dimensional geometry, usually represented by a sequence of points.
Particular subclasses of Curve define the type of interpolation between points. Curve is a noninstantiable class.
 
 
3. LineString : 

A LineString is a Curve with linear interpolation between points.
LineString Examples
On a world map, LineString objects could represent rivers.
In a city map, LineString objects could represent streets.


4. MultiCurve  : 

A MultiCurve is a geometry collection composed of Curve elements. MultiCurve is a noninstantiable class.
A MultiCurve is simple if and only if all of its elements are simple.
The only intersections between any two elements occur at points that are on the boundaries of both elements.
 
5. MultiLineStrings : 
 
A MultiLineString is a MultiCurve geometry collection composed of LineString elements.
 
 
6. MultiPolygons : 
 
A MultiPolygon is a MultiSurface object composed of Polygon elements. 
A MultiPolygon has no two Polygon elements with interiors that intersect.
A MultiPolygon has no two Polygon elements that cross (crossing is also forbidden by the previous assertion),
or that touch at an infinite number of points.
A MultiPolygon may not have cut lines, spikes, or punctures. A MultiPolygon is a regular, closed point set.
 
 
 
7. SurfacePolygons : 

A Polygon is a planar Surface representing a multisided geometry. 
It is defined by a single exterior boundary and zero or more interior boundaries, 
where each interior boundary defines a hole in the Polygon.






~~~

Relationships

~~~

The OpenGIS specification defines the following functions. 
They test the relationship between two geometry values g1 and g2.
The MySQL implementation uses minimum bounding rectangles, so these functions return the same result as
the corresponding MBR-based functions. The return values 1 and 0 indicate true and false, respectively.
 
 
1. Touches(g1,g2)   : 

Returns 1 or 0 to indicate whether g1 spatially touches g2. 
Two geometries spatially touch if the interiors of the geometries do not intersect,
but the boundary of one of the geometries intersects either the boundary or the interior of the other.
 


2. Crosses(g1,g2)   :  

Returns 1 if g1 spatially crosses g2. Returns NULL if g1 is a Polygon or a MultiPolygon, or if g2 is a Point or a MultiPoint.
Otherwise, returns 0.
The term spatially crosses denotes a spatial relation between two given geometries that has the following properties:
The two geometries intersect
Their intersection results in a geometry that has a dimension that is one less than the maximum dimension of the two given geometries
Their intersection is not equal to either of the two given geometries .


3. Within(g1,g2)   : 

Returns 1 or 0 to indicate whether g1 is spatially within g2. This tests the opposite relationship as Contains().
 
 
 
4. Overlaps(g1,g2)  : 

Returns 1 or 0 to indicate whether g1 spatially overlaps g2.
The term spatially overlaps is used if two geometries intersect and their intersection results in a geometry of the same dimension but not equal to either of the given geometries.
