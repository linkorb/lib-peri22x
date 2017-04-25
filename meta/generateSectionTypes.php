<?php

require __DIR__.'/../vendor/autoload.php';

use Memio\Memio\Config\Build;
use Memio\Model\File;
use Memio\Model\Object;
use Memio\Model\Property;

use Peri22x\Meta\Generator\SectionType\SectionTypeGenerator;

$prettyPrinter = Build::prettyPrinter();

/*
 * TODO Make perinatologie/realm-peri22x into a package (at minumum, have it
 * provide a composer.json) so that updates to sectionTypes can be generated for
 * this library:-
 *     $ composer require --dev perinatologie/realm-peri22x
 *     $ php meta/generateSectionTypes.php
 */
//$srcDir = __DIR__ . '/../vendor/perinatologie/realm-peri22x/sectionTypes';
$srcDir = dirname(dirname(__DIR__)) . '/realm-peri22x/sectionTypes';

$outDir = __DIR__ . '/../lib/Section';
$namespace = 'Peri22x\\Section';

foreach (new DirectoryIterator($srcDir) as $fileInfo) {
    if ($fileInfo->isDot() || $fileInfo->isDir()) {
        continue;
    }
    $xml = new XMLReader();
    $xml->open('file://' . $fileInfo->getRealPath());
    if (!$xml->next() || $xml->name !== 'sectionType') {
        continue;
    }
    $g = new SectionTypeGenerator($namespace, $xml->getAttribute('id'));

    while ($xml->read()) {
        if (($xml->nodeType === XMLReader::END_ELEMENT && $xml->name === 'sectionType')
            || $xml->nodeType === XMLReader::NONE
        ) {
            break;
        } elseif ($xml->nodeType !== XMLReader::ELEMENT || $xml->name !== 'field') {
            continue;
        }
        $g->addValue($xml->getAttribute('concept'));
    }

    $structure = Object::make($g->getClass())
        ->extend(new Object($g->getInheritedClass()))
    ;
    $property = Property::make($g->getConceptPropertyName())
        ->setDefaultValue($g->getValues())
        ->makeProtected()
    ;
    $structure->addProperty($property);

    $file = File::make($outDir . DIRECTORY_SEPARATOR . $g->getClassName() . '.php')
        ->setStructure($structure)
    ;
    $generatedCode = $prettyPrinter->generateCode($file);
    file_put_contents($file->getFilename(), $generatedCode);
}
