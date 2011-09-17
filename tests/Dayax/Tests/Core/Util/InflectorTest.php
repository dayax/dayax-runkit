<?php

namespace Dayax\Tests\Core\Util;
use Dayax\Core\Test\TestCase;
use Dayax\Core\Util\Inflector;

/**
 * Short description for class.
 *
 * @package		  cake.tests
 * @package       Cake.Test.Case.Utility
 */
class InflectorTest extends TestCase
{

    /**
     * teardown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Inflector::reset();
    }

    /**
     * testInflectingSingulars method
     *
     * @return void
     */
    public function testInflectingSingulars()
    {        
        $this->assertEquals(Inflector::singularize('categorias'), 'categoria');
        $this->assertEquals(Inflector::singularize('menus'), 'menu');
        $this->assertEquals(Inflector::singularize('news'), 'news');
        $this->assertEquals(Inflector::singularize('food_menus'), 'food_menu');
        $this->assertEquals(Inflector::singularize('Menus'), 'Menu');
        $this->assertEquals(Inflector::singularize('FoodMenus'), 'FoodMenu');
        $this->assertEquals(Inflector::singularize('houses'), 'house');
        $this->assertEquals(Inflector::singularize('powerhouses'), 'powerhouse');
        $this->assertEquals(Inflector::singularize('quizzes'), 'quiz');
        $this->assertEquals(Inflector::singularize('Buses'), 'Bus');
        $this->assertEquals(Inflector::singularize('buses'), 'bus');
        $this->assertEquals(Inflector::singularize('matrix_rows'), 'matrix_row');
        $this->assertEquals(Inflector::singularize('matrices'), 'matrix');
        $this->assertEquals(Inflector::singularize('vertices'), 'vertex');
        $this->assertEquals(Inflector::singularize('indices'), 'index');
        $this->assertEquals(Inflector::singularize('Aliases'), 'Alias');
        $this->assertEquals(Inflector::singularize('Alias'), 'Alias');
        $this->assertEquals(Inflector::singularize('Media'), 'Media');
        $this->assertEquals(Inflector::singularize('alumni'), 'alumnus');
        $this->assertEquals(Inflector::singularize('bacilli'), 'bacillus');
        $this->assertEquals(Inflector::singularize('cacti'), 'cactus');
        $this->assertEquals(Inflector::singularize('foci'), 'focus');
        $this->assertEquals(Inflector::singularize('fungi'), 'fungus');
        $this->assertEquals(Inflector::singularize('nuclei'), 'nucleus');
        $this->assertEquals(Inflector::singularize('octopuses'), 'octopus');
        $this->assertEquals(Inflector::singularize('radii'), 'radius');
        $this->assertEquals(Inflector::singularize('stimuli'), 'stimulus');
        $this->assertEquals(Inflector::singularize('syllabi'), 'syllabus');
        $this->assertEquals(Inflector::singularize('termini'), 'terminus');
        $this->assertEquals(Inflector::singularize('viri'), 'virus');
        $this->assertEquals(Inflector::singularize('people'), 'person');
        $this->assertEquals(Inflector::singularize('gloves'), 'glove');
        $this->assertEquals(Inflector::singularize('doves'), 'dove');
        $this->assertEquals(Inflector::singularize('lives'), 'life');
        $this->assertEquals(Inflector::singularize('knives'), 'knife');
        $this->assertEquals(Inflector::singularize('wolves'), 'wolf');
        $this->assertEquals(Inflector::singularize('slaves'), 'slave');
        $this->assertEquals(Inflector::singularize('shelves'), 'shelf');
        $this->assertEquals(Inflector::singularize('taxis'), 'taxi');
        $this->assertEquals(Inflector::singularize('taxes'), 'tax');
        $this->assertEquals(Inflector::singularize('Taxes'), 'Tax');
        $this->assertEquals(Inflector::singularize('AwesomeTaxes'), 'AwesomeTax');
        $this->assertEquals(Inflector::singularize('faxes'), 'fax');
        $this->assertEquals(Inflector::singularize('waxes'), 'wax');
        $this->assertEquals(Inflector::singularize('niches'), 'niche');
        $this->assertEquals(Inflector::singularize('waves'), 'wave');
        $this->assertEquals(Inflector::singularize('bureaus'), 'bureau');
        $this->assertEquals(Inflector::singularize('genetic_analyses'), 'genetic_analysis');
        $this->assertEquals(Inflector::singularize('doctor_diagnoses'), 'doctor_diagnosis');
        $this->assertEquals(Inflector::singularize('parantheses'), 'paranthesis');
        $this->assertEquals(Inflector::singularize('Causes'), 'Cause');
        $this->assertEquals(Inflector::singularize('colossuses'), 'colossus');
        $this->assertEquals(Inflector::singularize('diagnoses'), 'diagnosis');
        $this->assertEquals(Inflector::singularize('bases'), 'basis');
        $this->assertEquals(Inflector::singularize('analyses'), 'analysis');
        $this->assertEquals(Inflector::singularize('curves'), 'curve');
        $this->assertEquals(Inflector::singularize('cafes'), 'cafe');
        $this->assertEquals(Inflector::singularize('roofs'), 'roof');
        $this->assertEquals(Inflector::singularize(''), '');
    }

    /**
     * testInflectingPlurals method
     *
     * @return void
     */
    public function testInflectingPlurals()
    {        
        $this->assertEquals(Inflector::pluralize('categoria'), 'categorias');
        $this->assertEquals(Inflector::pluralize('house'), 'houses');
        $this->assertEquals(Inflector::pluralize('powerhouse'), 'powerhouses');
        $this->assertEquals(Inflector::pluralize('Bus'), 'Buses');
        $this->assertEquals(Inflector::pluralize('bus'), 'buses');
        $this->assertEquals(Inflector::pluralize('menu'), 'menus');
        $this->assertEquals(Inflector::pluralize('news'), 'news');
        $this->assertEquals(Inflector::pluralize('food_menu'), 'food_menus');
        $this->assertEquals(Inflector::pluralize('Menu'), 'Menus');
        $this->assertEquals(Inflector::pluralize('FoodMenu'), 'FoodMenus');
        $this->assertEquals(Inflector::pluralize('quiz'), 'quizzes');
        $this->assertEquals(Inflector::pluralize('matrix_row'), 'matrix_rows');
        $this->assertEquals(Inflector::pluralize('matrix'), 'matrices');
        $this->assertEquals(Inflector::pluralize('vertex'), 'vertices');
        $this->assertEquals(Inflector::pluralize('index'), 'indices');
        $this->assertEquals(Inflector::pluralize('Alias'), 'Aliases');
        $this->assertEquals(Inflector::pluralize('Aliases'), 'Aliases');
        $this->assertEquals(Inflector::pluralize('Media'), 'Media');
        $this->assertEquals(Inflector::pluralize('alumnus'), 'alumni');
        $this->assertEquals(Inflector::pluralize('bacillus'), 'bacilli');
        $this->assertEquals(Inflector::pluralize('cactus'), 'cacti');
        $this->assertEquals(Inflector::pluralize('focus'), 'foci');
        $this->assertEquals(Inflector::pluralize('fungus'), 'fungi');
        $this->assertEquals(Inflector::pluralize('nucleus'), 'nuclei');
        $this->assertEquals(Inflector::pluralize('octopus'), 'octopuses');
        $this->assertEquals(Inflector::pluralize('radius'), 'radii');
        $this->assertEquals(Inflector::pluralize('stimulus'), 'stimuli');
        $this->assertEquals(Inflector::pluralize('syllabus'), 'syllabi');
        $this->assertEquals(Inflector::pluralize('terminus'), 'termini');
        $this->assertEquals(Inflector::pluralize('virus'), 'viri');
        $this->assertEquals(Inflector::pluralize('person'), 'people');
        $this->assertEquals(Inflector::pluralize('people'), 'people');
        $this->assertEquals(Inflector::pluralize('glove'), 'gloves');
        $this->assertEquals(Inflector::pluralize('crisis'), 'crises');
        $this->assertEquals(Inflector::pluralize('tax'), 'taxes');
        $this->assertEquals(Inflector::pluralize('wave'), 'waves');
        $this->assertEquals(Inflector::pluralize('bureau'), 'bureaus');
        $this->assertEquals(Inflector::pluralize('cafe'), 'cafes');
        $this->assertEquals(Inflector::pluralize('roof'), 'roofs');
        $this->assertEquals(Inflector::pluralize(''), '');
    }

    /**
     * testInflectorSlug method
     *
     * @return void
     */
    public function testInflectorSlug()
    {
        $result = Inflector::slug('Foo Bar: Not just for breakfast any-more');
        $expected = 'Foo_Bar_Not_just_for_breakfast_any_more';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('this/is/a/path');
        $expected = 'this_is_a_path';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('Foo Bar: Not just for breakfast any-more', "-");
        $expected = 'Foo-Bar-Not-just-for-breakfast-any-more';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('Foo Bar: Not just for breakfast any-more', "+");
        $expected = 'Foo+Bar+Not+just+for+breakfast+any+more';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('Äpfel Über Öl grün ärgert groß öko', '-');
        $expected = 'Aepfel-Ueber-Oel-gruen-aergert-gross-oeko';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('The truth - and- more- news', '-');
        $expected = 'The-truth-and-more-news';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('The truth: and more news', '-');
        $expected = 'The-truth-and-more-news';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('La langue française est un attribut de souveraineté en France', '-');
        $expected = 'La-langue-francaise-est-un-attribut-de-souverainete-en-France';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('!@$#exciting stuff! - what !@-# was that?', '-');
        $expected = 'exciting-stuff-what-was-that';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('20% of profits went to me!', '-');
        $expected = '20-of-profits-went-to-me';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('#this melts your face1#2#3', '-');
        $expected = 'this-melts-your-face1-2-3';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('controller/action/りんご/1');
        $expected = 'controller_action_りんご_1';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('の話が出たので大丈夫かなあと');
        $expected = 'の話が出たので大丈夫かなあと';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('posts/view/한국어/page:1/sort:asc');
        $expected = 'posts_view_한국어_page_1_sort_asc';
        $this->assertEquals($expected, $result);
    }

    /**
     * testInflectorSlugWithMap method
     *
     * @return void
     */
    public function testInflectorSlugWithMap()
    {
        Inflector::rules('transliteration', array('/r/' => '1'));
        $result = Inflector::slug('replace every r');
        $expected = '1eplace_eve1y_1';
        $this->assertEquals($expected, $result);

        $result = Inflector::slug('replace every r', '_');
        $expected = '1eplace_eve1y_1';
        $this->assertEquals($expected, $result);
    }

    /**
     * testInflectorSlugWithMapOverridingDefault method
     *
     * @return void
     */
    public function testInflectorSlugWithMapOverridingDefault()
    {
        Inflector::rules('transliteration', array('/å/' => 'aa', '/ø/' => 'oe'));
        $result = Inflector::slug('Testing æ ø å', '-');
        $expected = 'Testing-ae-oe-aa';
        $this->assertEquals($expected, $result);
    }

    /**
     * testInflectorUnderscore method
     *
     * @return void
     */
    public function testInflectorUnderscore()
    {
        /*$this->assertIdentical(Inflector::underscore('TestThing'), 'test_thing');
        $this->assertIdentical(Inflector::underscore('testThing'), 'test_thing');
        $this->assertIdentical(Inflector::underscore('TestThingExtra'), 'test_thing_extra');
        $this->assertIdentical(Inflector::underscore('testThingExtra'), 'test_thing_extra');

        // Identical checks test the cache code path.
        $this->assertIdentical(Inflector::underscore('TestThing'), 'test_thing');
        $this->assertIdentical(Inflector::underscore('testThing'), 'test_thing');
        $this->assertIdentical(Inflector::underscore('TestThingExtra'), 'test_thing_extra');
        $this->assertIdentical(Inflector::underscore('testThingExtra'), 'test_thing_extra');

        // Test stupid values
        $this->assertIdentical(Inflector::underscore(''), '');
        $this->assertIdentical(Inflector::underscore(0), '0');
        $this->assertIdentical(Inflector::underscore(false), '');*/
        
        $this->assertEquals(Inflector::underscore('TestThing'), 'test_thing');
        $this->assertEquals(Inflector::underscore('testThing'), 'test_thing');
        $this->assertEquals(Inflector::underscore('TestThingExtra'), 'test_thing_extra');
        $this->assertEquals(Inflector::underscore('testThingExtra'), 'test_thing_extra');

        // Identical checks test the cache code path.
        $this->assertEquals(Inflector::underscore('TestThing'), 'test_thing');
        $this->assertEquals(Inflector::underscore('testThing'), 'test_thing');
        $this->assertEquals(Inflector::underscore('TestThingExtra'), 'test_thing_extra');
        $this->assertEquals(Inflector::underscore('testThingExtra'), 'test_thing_extra');

        // Test stupid values
        $this->assertEquals(Inflector::underscore(''), '');
        $this->assertEquals(Inflector::underscore(0), '0');
        $this->assertEquals(Inflector::underscore(false), '');
        //$this->markTestIncomplete();
    }

    /**
     * testVariableNaming method
     *
     * @return void
     */
    public function testVariableNaming()
    {
        $this->assertEquals(Inflector::variable('test_field'), 'testField');
        $this->assertEquals(Inflector::variable('test_fieLd'), 'testFieLd');
        $this->assertEquals(Inflector::variable('test field'), 'testField');
        $this->assertEquals(Inflector::variable('Test_field'), 'testField');
    }

    /**
     * testClassNaming method
     *
     * @return void
     */
    public function testClassNaming()
    {
        $this->assertEquals(Inflector::classify('artists_genres'), 'ArtistsGenre');
        $this->assertEquals(Inflector::classify('file_systems'), 'FileSystem');
        $this->assertEquals(Inflector::classify('news'), 'News');
        $this->assertEquals(Inflector::classify('bureaus'), 'Bureau');
    }

    /**
     * testTableNaming method
     *
     * @return void
     */
    public function testTableNaming()
    {
        $this->assertEquals(Inflector::tableize('ArtistsGenre'), 'artists_genres');
        $this->assertEquals(Inflector::tableize('FileSystem'), 'file_systems');
        $this->assertEquals(Inflector::tableize('News'), 'news');
        $this->assertEquals(Inflector::tableize('Bureau'), 'bureaus');
    }

    /**
     * testHumanization method
     *
     * @return void
     */
    public function testHumanization()
    {
        $this->assertEquals(Inflector::humanize('posts'), 'Posts');
        $this->assertEquals(Inflector::humanize('posts_tags'), 'Posts Tags');
        $this->assertEquals(Inflector::humanize('file_systems'), 'File Systems');
    }

    /**
     * testCustomPluralRule method
     *
     * @return void
     */
    public function testCustomPluralRule()
    {
        Inflector::rules('plural', array('/^(custom)$/i' => '\1izables'));
        $this->assertEquals(Inflector::pluralize('custom'), 'customizables');

        Inflector::rules('plural', array('uninflected' => array('uninflectable')));
        $this->assertEquals(Inflector::pluralize('uninflectable'), 'uninflectable');

        Inflector::rules('plural', array(
            'rules' => array('/^(alert)$/i' => '\1ables'),
            'uninflected' => array('noflect', 'abtuse'),
            'irregular' => array('amaze' => 'amazable', 'phone' => 'phonezes')
        ));
        $this->assertEquals(Inflector::pluralize('noflect'), 'noflect');
        $this->assertEquals(Inflector::pluralize('abtuse'), 'abtuse');
        $this->assertEquals(Inflector::pluralize('alert'), 'alertables');
        $this->assertEquals(Inflector::pluralize('amaze'), 'amazable');
        $this->assertEquals(Inflector::pluralize('phone'), 'phonezes');
    }

    /**
     * testCustomSingularRule method
     *
     * @return void
     */
    public function testCustomSingularRule()
    {
        Inflector::rules('singular', array('/(eple)r$/i' => '\1', '/(jente)r$/i' => '\1'));

        $this->assertEquals(Inflector::singularize('epler'), 'eple');
        $this->assertEquals(Inflector::singularize('jenter'), 'jente');

        Inflector::rules('singular', array(
            'rules' => array('/^(bil)er$/i' => '\1', '/^(inflec|contribu)tors$/i' => '\1ta'),
            'uninflected' => array('singulars'),
            'irregular' => array('spins' => 'spinor')
        ));

        $this->assertEquals(Inflector::singularize('inflectors'), 'inflecta');
        $this->assertEquals(Inflector::singularize('contributors'), 'contributa');
        $this->assertEquals(Inflector::singularize('spins'), 'spinor');
        $this->assertEquals(Inflector::singularize('singulars'), 'singulars');
    }

    /**
     * testCustomTransliterationRule method
     *
     * @return void
     */
    public function testCustomTransliterationRule()
    {
        //FIXME: CAnnot test this thing
        //$this->assertEquals('Testing_ae_o_a',Inflector::slug('Testing æ ø å'));

        Inflector::rules('transliteration', array('/å/' => 'aa', '/ø/' => 'oe'));
        $this->assertEquals('Testing_ae_oe_aa',Inflector::slug('Testing æ ø å') );

        Inflector::rules('transliteration', array('/ä|æ/' => 'ae', '/å/' => 'aa'), true);
        $this->assertEquals('Testing_ae_ø_aa', Inflector::slug('Testing æ ø å'));        
    }

    /**
     * test that setting new rules clears the inflector caches.
     *
     * @return void
     */
    public function testRulesClearsCaches()
    {
        $this->assertEquals(Inflector::singularize('Bananas'), 'Banana');
        $this->assertEquals(Inflector::tableize('Banana'), 'bananas');
        $this->assertEquals(Inflector::pluralize('Banana'), 'Bananas');

        Inflector::rules('singular', array(
            'rules' => array('/(.*)nas$/i' => '\1zzz')
        ));
        $this->assertEquals('Banazzz', Inflector::singularize('Bananas'), 'Was inflected with old rules.');

        Inflector::rules('plural', array(
            'rules' => array('/(.*)na$/i' => '\1zzz')
        ));
        $this->assertEquals('Banazzz', Inflector::pluralize('Banana'), 'Was inflected with old rules.');
    }

    /**
     * Test resetting inflection rules.
     *
     * @return void
     */
    public function testCustomRuleWithReset()
    {
        $uninflected = array('atlas', 'lapis', 'onibus', 'pires', 'virus', '.*x');
        $pluralIrregular = array('as' => 'ases');

        Inflector::rules('singular', array(
            'rules' => array('/^(.*)(a|e|o|u)is$/i' => '\1\2l'),
            'uninflected' => $uninflected,
                ), true);

        Inflector::rules('plural', array(
            'rules' => array(
                '/^(.*)(a|e|o|u)l$/i' => '\1\2is',
            ),
            'uninflected' => $uninflected,
            'irregular' => $pluralIrregular
                ), true);

        $this->assertEquals(Inflector::pluralize('Alcool'), 'Alcoois');
        $this->assertEquals(Inflector::pluralize('Atlas'), 'Atlas');
        $this->assertEquals(Inflector::singularize('Alcoois'), 'Alcool');
        $this->assertEquals(Inflector::singularize('Atlas'), 'Atlas');
    }

}