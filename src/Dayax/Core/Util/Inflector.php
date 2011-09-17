<?php

/*
 * This file is part of the dayax project.
 *
 * (c) Anthonius Munthi <toni.dayax@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dayax\Core\Util;

/**
 * Inflector Class.
 *
 * @author Anthonius Munthi <toni.dayax@gmail.com>
 */
class Inflector
{
    static protected $plural = array(
        'rules' => array(
            '/(s)tatus$/i' => '\1\2tatuses',
            '/(quiz)$/i' => '\1zes',
            '/^(ox)$/i' => '\1\2en',
            '/([m|l])ouse$/i' => '\1ice',
            '/(matr|vert|ind)(ix|ex)$/i' => '\1ices',
            '/(x|ch|ss|sh)$/i' => '\1es',
            '/([^aeiouy]|qu)y$/i' => '\1ies',
            '/(hive)$/i' => '\1s',
            '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '\1a',
            '/(p)erson$/i' => '\1eople',
            '/(m)an$/i' => '\1en',
            '/(c)hild$/i' => '\1hildren',
            '/(buffal|tomat)o$/i' => '\1\2oes',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
            '/us$/i' => 'uses',
            '/(alias)$/i' => '\1es',
            '/(ax|cris|test)is$/i' => '\1es',
            '/s$/' => 's',
            '/^$/' => '',
            '/$/' => 's',
        ),
        'uninflected' => array(
            '.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', 'people'
        ),
        'irregular' => array(
            'atlas' => 'atlases',
            'beef' => 'beefs',
            'brother' => 'brothers',
            'cafe' => 'cafes',
            'child' => 'children',
            'corpus' => 'corpuses',
            'cow' => 'cows',
            'ganglion' => 'ganglions',
            'genie' => 'genies',
            'genus' => 'genera',
            'graffito' => 'graffiti',
            'hoof' => 'hoofs',
            'loaf' => 'loaves',
            'man' => 'men',
            'money' => 'monies',
            'mongoose' => 'mongooses',
            'move' => 'moves',
            'mythos' => 'mythoi',
            'niche' => 'niches',
            'numen' => 'numina',
            'occiput' => 'occiputs',
            'octopus' => 'octopuses',
            'opus' => 'opuses',
            'ox' => 'oxen',
            'penis' => 'penises',
            'person' => 'people',
            'sex' => 'sexes',
            'soliloquy' => 'soliloquies',
            'testis' => 'testes',
            'trilby' => 'trilbys',
            'turf' => 'turfs'
        )
    );

    /**
     * Singular inflector rules
     *
     * @var array
     */
    static protected $singular = array(
        'rules' => array(
            '/(s)tatuses$/i' => '\1\2tatus',
            '/^(.*)(menu)s$/i' => '\1\2',
            '/(quiz)zes$/i' => '\\1',
            '/(matr)ices$/i' => '\1ix',
            '/(vert|ind)ices$/i' => '\1ex',
            '/^(ox)en/i' => '\1',
            '/(alias)(es)*$/i' => '\1',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$/i' => '\1us',
            '/([ftw]ax)es/i' => '\1',
            '/(cris|ax|test)es$/i' => '\1is',
            '/(shoe|slave)s$/i' => '\1',
            '/(o)es$/i' => '\1',
            '/ouses$/' => 'ouse',
            '/([^a])uses$/' => '\1us',
            '/([m|l])ice$/i' => '\1ouse',
            '/(x|ch|ss|sh)es$/i' => '\1',
            '/(m)ovies$/i' => '\1\2ovie',
            '/(s)eries$/i' => '\1\2eries',
            '/([^aeiouy]|qu)ies$/i' => '\1y',
            '/([lr])ves$/i' => '\1f',
            '/(tive)s$/i' => '\1',
            '/(hive)s$/i' => '\1',
            '/(drive)s$/i' => '\1',
            '/([^fo])ves$/i' => '\1fe',
            '/(^analy)ses$/i' => '\1sis',
            '/(analy|ba|diagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
            '/([ti])a$/i' => '\1um',
            '/(p)eople$/i' => '\1\2erson',
            '/(m)en$/i' => '\1an',
            '/(c)hildren$/i' => '\1\2hild',
            '/(n)ews$/i' => '\1\2ews',
            '/eaus$/' => 'eau',
            '/^(.*us)$/' => '\\1',
            '/s$/i' => ''
        ),
        'uninflected' => array(
            '.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox', '.*sheep', '.*ss'
        ),
        'irregular' => array(
            'waves' => 'wave',
            'curves' => 'curve'
        )
    );

    /**
     * Words that should not be inflected
     *
     * @var array
     */
    static protected $uninflected = array(
        'Amoyese', 'bison', 'Borghese', 'bream', 'breeches', 'britches', 'buffalo', 'cantus',
        'carp', 'chassis', 'clippers', 'cod', 'coitus', 'Congoese', 'contretemps', 'corps',
        'debris', 'diabetes', 'djinn', 'eland', 'elk', 'equipment', 'Faroese', 'flounder',
        'Foochowese', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'graffiti',
        'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings',
        'jackanapes', 'Kiplingese', 'Kongoese', 'Lucchese', 'mackerel', 'Maltese', 'media',
        'mews', 'moose', 'mumps', 'Nankingese', 'news', 'nexus', 'Niasese',
        'Pekingese', 'Piedmontese', 'pincers', 'Pistoiese', 'pliers', 'Portuguese',
        'proceedings', 'rabies', 'rice', 'rhinoceros', 'salmon', 'Sarawakese', 'scissors',
        'sea[- ]bass', 'series', 'Shavese', 'shears', 'siemens', 'species', 'swine', 'testes',
        'trousers', 'trout', 'tuna', 'Vermontese', 'Wenchowese', 'whiting', 'wildebeest',
        'Yengeese'
    );

    /**
     * Default map of accented and special characters to ASCII characters
     *
     * @var array
     */
    static protected $transliteration = array(
        '/ä|æ|ǽ/' => 'ae',
        '/ö|œ/' => 'oe',
        '/ü/' => 'ue',
        '/Ä/' => 'Ae',
        '/Ü/' => 'Ue',
        '/Ö/' => 'Oe',
        '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
        '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
        '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
        '/ç|ć|ĉ|ċ|č/' => 'c',
        '/Ð|Ď|Đ/' => 'D',
        '/ð|ď|đ/' => 'd',
        '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
        '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
        '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
        '/ĝ|ğ|ġ|ģ/' => 'g',
        '/Ĥ|Ħ/' => 'H',
        '/ĥ|ħ/' => 'h',
        '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
        '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
        '/Ĵ/' => 'J',
        '/ĵ/' => 'j',
        '/Ķ/' => 'K',
        '/ķ/' => 'k',
        '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
        '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
        '/Ñ|Ń|Ņ|Ň/' => 'N',
        '/ñ|ń|ņ|ň|ŉ/' => 'n',
        '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
        '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
        '/Ŕ|Ŗ|Ř/' => 'R',
        '/ŕ|ŗ|ř/' => 'r',
        '/Ś|Ŝ|Ş|Š/' => 'S',
        '/ś|ŝ|ş|š|ſ/' => 's',
        '/Ţ|Ť|Ŧ/' => 'T',
        '/ţ|ť|ŧ/' => 't',
        '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
        '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
        '/Ý|Ÿ|Ŷ/' => 'Y',
        '/ý|ÿ|ŷ/' => 'y',
        '/Ŵ/' => 'W',
        '/ŵ/' => 'w',
        '/Ź|Ż|Ž/' => 'Z',
        '/ź|ż|ž/' => 'z',
        '/Æ|Ǽ/' => 'AE',
        '/ß/' => 'ss',
        '/Ĳ/' => 'IJ',
        '/ĳ/' => 'ij',
        '/Œ/' => 'OE',
        '/ƒ/' => 'f'
    );

    /**
     * Method cache array.
     *
     * @var array
     */
    static protected $cache = array();

    /**
     * The initial state of Inflector so reset() works.
     *
     * @var array
     */
    static protected $initialState = array();

    /**
     * Cache inflected values, and return if already available
     *
     * @param string $type Inflection type
     * @param string $key Original value
     * @param string $value Inflected value
     * @return string Inflected value, from cache
     */
    static protected function cache($type, $key, $value = false)
    {
        $key = '_' . $key;
        $type = '_' . $type;
        if ($value !== false) {
            self::$cache[$type][$key] = $value;
            return $value;
        }
        if (!isset(self::$cache[$type][$key])) {
            return false;
        }
        return self::$cache[$type][$key];
    }

    /**
     * Clears Inflectors inflected value caches. And resets the inflection
     * rules to the initial values.
     *
     * @return void
     */
    static public function reset()
    {
        if (empty(self::$initialState)) {
            self::$initialState = get_class_vars('Inflector');
            return;
        }
        foreach (self::$initialState as $key => $val) {
            if ($key != '_initialState') {
                self::${$key} = $val;
            }
        }
    }

    /**
     * Adds custom inflection $rules, of either 'plural', 'singular' or 'transliteration' $type.
     *
     * ### Usage:
     *
     * {{{
     * Inflector::rules('plural', array('/^(inflect)or$/i' => '\1ables'));
     * Inflector::rules('plural', array(
     * 'rules' => array('/^(inflect)ors$/i' => '\1ables'),
     * 'uninflected' => array('dontinflectme'),
     * 'irregular' => array('red' => 'redlings')
     * ));
     * Inflector::rules('transliteration', array('/å/' => 'aa'));
     * }}}
     *
     * @param string $type The type of inflection, either 'plural', 'singular' or 'transliteration'
     * @param array $rules Array of rules to be added.
     * @param boolean $reset If true, will unset default inflections for all
     * new rules that are being defined in $rules.
     * @return void
     */
    static public function rules($type, $rules, $reset = false)
    {
        $var =  $type;

        switch ($type) {
            case 'transliteration':
                if ($reset) {
                    self::$transliteration = $rules;
                } else {
                    self::$transliteration = $rules + self::$transliteration;
                }
                break;

            default:
                foreach ($rules as $rule => $pattern) {
                    if (is_array($pattern)) {
                        if ($reset) {
                            self::${$var}[$rule] = $pattern;
                        } else {
                            self::${$var}[$rule] = array_merge($pattern, self::${$var}[$rule]);
                        }
                        unset($rules[$rule], self::${$var}['cache' . ucfirst($rule)]);
                        if (isset(self::${$var}['merged'][$rule])) {
                            unset(self::${$var}['merged'][$rule]);
                        }
                        if ($type === 'plural') {
                            self::$cache['pluralize'] = self::$cache['tableize'] = array();
                        } elseif ($type === 'singular') {
                            self::$cache['singularize'] = array();
                        }
                    }
                }
                self::${$var}['rules'] = array_merge($rules, self::${$var}['rules']);
                break;
        }
    }

    /**
     * Return $word in plural form.
     *
     * @param string $word Word in singular
     * @return string Word in plural
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function pluralize($word)
    {

        if (isset(self::$cache['pluralize'][$word])) {
            return self::$cache['pluralize'][$word];
        }

        if (!isset(self::$plural['merged']['irregular'])) {
            self::$plural['merged']['irregular'] = self::$plural['irregular'];
        }

        if (!isset(self::$plural['merged']['uninflected'])) {
            self::$plural['merged']['uninflected'] = array_merge(self::$plural['uninflected'], self::$uninflected);
        }

        if (!isset(self::$plural['cacheUninflected']) || !isset(self::$plural['cacheIrregular'])) {
            self::$plural['cacheUninflected'] = '(?:' . implode('|', self::$plural['merged']['uninflected']) . ')';
            self::$plural['cacheIrregular'] = '(?:' . implode('|', array_keys(self::$plural['merged']['irregular'])) . ')';
        }

        if (preg_match('/(.*)\\b(' . self::$plural['cacheIrregular'] . ')$/i', $word, $regs)) {
            self::$cache['pluralize'][$word] = $regs[1] . substr($word, 0, 1) . substr(self::$plural['merged']['irregular'][strtolower($regs[2])], 1);
            return self::$cache['pluralize'][$word];
        }

        if (preg_match('/^(' . self::$plural['cacheUninflected'] . ')$/i', $word, $regs)) {
            self::$cache['pluralize'][$word] = $word;
            return $word;
        }

        foreach (self::$plural['rules'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['pluralize'][$word] = preg_replace($rule, $replacement, $word);
                return self::$cache['pluralize'][$word];
            }
        }
    }

    /**
     * Return $word in singular form.
     *
     * @param string $word Word in plural
     * @return string Word in singular
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function singularize($word)
    {

        if (isset(self::$cache['singularize'][$word])) {
            return self::$cache['singularize'][$word];
        }

        if (!isset(self::$singular['merged']['uninflected'])) {
            self::$singular['merged']['uninflected'] = array_merge(
                    self::$singular['uninflected'], self::$uninflected
            );
        }

        if (!isset(self::$singular['merged']['irregular'])) {
            self::$singular['merged']['irregular'] = array_merge(
                    self::$singular['irregular'], array_flip(self::$plural['irregular'])
            );
        }

        if (!isset(self::$singular['cacheUninflected']) || !isset(self::$singular['cacheIrregular'])) {
            self::$singular['cacheUninflected'] = '(?:' . join('|', self::$singular['merged']['uninflected']) . ')';
            self::$singular['cacheIrregular'] = '(?:' . join('|', array_keys(self::$singular['merged']['irregular'])) . ')';
        }

        if (preg_match('/(.*)\\b(' . self::$singular['cacheIrregular'] . ')$/i', $word, $regs)) {
            self::$cache['singularize'][$word] = $regs[1] . substr($word, 0, 1) . substr(self::$singular['merged']['irregular'][strtolower($regs[2])], 1);
            return self::$cache['singularize'][$word];
        }

        if (preg_match('/^(' . self::$singular['cacheUninflected'] . ')$/i', $word, $regs)) {
            self::$cache['singularize'][$word] = $word;
            return $word;
        }

        foreach (self::$singular['rules'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['singularize'][$word] = preg_replace($rule, $replacement, $word);
                return self::$cache['singularize'][$word];
            }
        }
        self::$cache['singularize'][$word] = $word;
        return $word;
    }

    /**
     * Returns the given lower_case_and_underscored_word as a CamelCased word.
     *
     * @param string $lowerCaseAndUnderscoredWord Word to camelize
     * @return string Camelized word. LikeThis.
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function camelize($lowerCaseAndUnderscoredWord)
    {
        if (!($result = self::cache(__FUNCTION__, $lowerCaseAndUnderscoredWord))) {
            $result = str_replace(' ', '', Inflector::humanize($lowerCaseAndUnderscoredWord));
            self::cache(__FUNCTION__, $lowerCaseAndUnderscoredWord, $result);
        }
        return $result;
    }

    /**
     * Returns the given camelCasedWord as an underscored_word.
     *
     * @param string $camelCasedWord Camel-cased word to be "underscorized"
     * @return string Underscore-syntaxed version of the $camelCasedWord
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function underscore($camelCasedWord)
    {
        if (!($result = self::cache(__FUNCTION__, $camelCasedWord))) {
            $result = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
            self::cache(__FUNCTION__, $camelCasedWord, $result);
        }
        return $result;
    }

    /**
     * Returns the given underscored_word_group as a Human Readable Word Group.
     * (Underscores are replaced by spaces and capitalized following words.)
     *
     * @param string $lowerCaseAndUnderscoredWord String to be made more readable
     * @return string Human-readable string
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function humanize($lowerCaseAndUnderscoredWord)
    {
        if (!($result = self::cache(__FUNCTION__, $lowerCaseAndUnderscoredWord))) {
            $result = ucwords(str_replace('_', ' ', $lowerCaseAndUnderscoredWord));
            self::cache(__FUNCTION__, $lowerCaseAndUnderscoredWord, $result);
        }
        return $result;
    }

    /**
     * Returns corresponding table name for given model $className. ("people" for the model class "Person").
     *
     * @param string $className Name of class to get database table name for
     * @return string Name of the database table for given class
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function tableize($className)
    {
        if (!($result = self::cache(__FUNCTION__, $className))) {
            $result = Inflector::pluralize(Inflector::underscore($className));
            self::cache(__FUNCTION__, $className, $result);
        }
        return $result;
    }

    /**
     * Returns Cake model class name ("Person" for the database table "people".) for given database table.
     *
     * @param string $tableName Name of database table to get class name for
     * @return string Class name
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function classify($tableName)
    {
        if (!($result = self::cache(__FUNCTION__, $tableName))) {
            $result = Inflector::camelize(Inflector::singularize($tableName));
            self::cache(__FUNCTION__, $tableName, $result);
        }
        return $result;
    }

    /**
     * Returns camelBacked version of an underscored string.
     *
     * @param string $string
     * @return string in variable form
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function variable($string)
    {
        if (!($result = self::cache(__FUNCTION__, $string))) {
            $string2 = Inflector::camelize(Inflector::underscore($string));
            $replace = strtolower(substr($string2, 0, 1));
            $result = preg_replace('/\\w/', $replace, $string2, 1);
            self::cache(__FUNCTION__, $string, $result);
        }
        return $result;
    }

    /**
     * Returns a string with all spaces converted to underscores (by default), accented
     * characters converted to non-accented characters, and non word characters removed.
     *
     * @param string $string the string you want to slug
     * @param string $replacement will replace keys in map
     * @return string
     * @link http://book.cakephp.org/view/1479/Class-methods
     */
    static public function slug($string, $replacement = '_')
    {
        $quotedReplacement = preg_quote($replacement, '/');

        $merge = array(
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );

        $map = self::$transliteration + $merge;
        return preg_replace(array_keys($map), array_values($map), $string);
    }
}

