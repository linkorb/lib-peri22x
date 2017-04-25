# Generate Section classes

To generate Section classes, first checkout `linkorb/peri22x` into a directory
adjacent to this project:-

    $ cd path/to/projects
    $ git clone https://github.com/perinatologie/realm-peri22x.git
    $ ls
    lib-peri22x realm-peri22x
    $ cd lib-peri22x

The following command will generate the sections, in `lib/Section/`, using the
xml files in `realm-peri22x/sectionTypes/`:-

    $ php meta/generateSectionTypes.php
