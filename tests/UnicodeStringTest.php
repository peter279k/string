<?php
/* ===========================================================================
 * Opis Project
 * http://opis.io
 * ===========================================================================
 * Copyright 2016 Marius Sarca
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================================ */

namespace Opis\String\Test;

use Opis\String\UnicodeString as wstring;

class UnicodeStringTest extends \PHPUnit_Framework_TestCase
{
    public function testLength()
    {
        $this->assertEquals(10, wstring::from('ăĂâÂîÎşŞţŢ')->length());
    }

    public function testToString()
    {
        $this->assertEquals('ăĂâÂîÎşŞţŢ', (string) wstring::from('ăĂâÂîÎşŞţŢ'));
    }

    public function testArrayAccess()
    {
        $str = wstring::from('ăĂâÂîÎşŞţŢ');
        $this->assertEquals('ă', $str[0]);
        $this->assertEquals('Ţ', $str[9]);
        $this->assertEquals('Î', $str[5]);
    }

    public function testEquals()
    {
        $this->assertTrue(wstring::from('abc')->equals('abc'));
        $this->assertFalse(wstring::from('Abc')->equals('abc'));
    }

    public function testEqualsCaseInsensitive()
    {
        $this->assertTrue(wstring::from('Abc')->equals('aBc', true));
        $this->assertFalse(wstring::from('Abd')->equals('aBc', true));
    }

    public function testCompareTo()
    {
        $this->assertEquals(0, wstring::from('abc')->compareTo('abc'));
        $this->assertEquals(1, wstring::from('abcd')->compareTo('abc'));
        $this->assertEquals(1, wstring::from('abc')->compareTo('Abc'));
        $this->assertEquals(-1, wstring::from('Abc')->compareTo('abc'));
        $this->assertEquals(-1, wstring::from('abc')->compareTo('abcd'));
    }

    public function testCompareToCaseInsensitive()
    {
        $this->assertEquals(0, wstring::from('abc')->compareTo('abc', true));
        $this->assertEquals(1, wstring::from('abcd')->compareTo('abc', true));
        $this->assertEquals(0, wstring::from('abc')->compareTo('Abc', true));
        $this->assertEquals(0, wstring::from('Abc')->compareTo('abc', true));
        $this->assertEquals(-1, wstring::from('abc')->compareTo('abcd', true));
    }

    public function testContains()
    {
        $this->assertTrue(wstring::from('abcdefg')->contains('cde'));
        $this->assertTrue(wstring::from('abcdefg')->contains('abc'));
        $this->assertTrue(wstring::from('abcdefg')->contains('efg'));
        $this->assertFalse(wstring::from('abcdefg')->contains('cda'));
    }


    public function testContainsCaseInsensitive()
    {
        $this->assertTrue(wstring::from('abcdefg')->contains('CDE', true));
        $this->assertTrue(wstring::from('abcdefg')->contains('ABC', true));
        $this->assertTrue(wstring::from('abcdefg')->contains('EFG', true));
        $this->assertFalse(wstring::from('abcdefg')->contains('CDA'));
    }

    public function testStartsWith()
    {
        $this->assertTrue(wstring::from('abcde')->startsWith('ab'));
        $this->assertFalse(wstring::from('abcde')->startsWith('ac'));
    }

    public function testStartsWithCaseInsensitive()
    {
        $this->assertTrue(wstring::from('abcde')->startsWith('AB', true));
        $this->assertFalse(wstring::from('abcde')->startsWith('AC', true));
    }

    public function testEndsWith()
    {
        $this->assertTrue(wstring::from('abcde')->endsWith('de'));
        $this->assertFalse(wstring::from('abcde')->endsWith('ce'));
    }

    public function testEndsWithOffsetShouldBeLessThanZero()
    {
        $this->assertFalse(wstring::from('abcde')->endsWith('ceffff'));
    }

    public function testEndsWithCaseInsensitive()
    {
        $this->assertTrue(wstring::from('abcde')->endsWith('DE', true));
        $this->assertFalse(wstring::from('abcde')->endsWith('CE', true));
    }

    public function testIndexOf()
    {
        $this->assertEquals(0, wstring::from('abcabc')->indexOf('ab'));
        $this->assertEquals(3, wstring::from('abcabc')->indexOf('ab', 1));
    }

    public function testIndexOfShouldBeFalse()
    {
        $this->assertFalse(wstring::from('abcabc')->indexOf('abcdefg'));
    }

    public function testIndexOfOffsetShouldBeChangedIntoZero()
    {
        $this->assertEquals(0, wstring::from('abcabc')->indexOf('ab', -1));
    }

    public function testIndexOfCaseInsensitive()
    {
        $this->assertEquals(0, wstring::from('abcabc')->indexOf('AB', 0, true));
        $this->assertEquals(3, wstring::from('abcabc')->indexOf('AB', 1, true));
    }

    public function testLastIndexOf()
    {
        $this->assertEquals(3, wstring::from('abcabcAbc')->lastIndexOf('ab'));
    }

    public function testLastIndexOfShouldBeFalse()
    {
        $this->assertFalse(wstring::from('abcabcAbc')->lastIndexOf('abcdefghijk'));
    }

    public function testLastIndexOfCaseInsensitive()
    {
        $this->assertEquals(6, wstring::from('abcabcAbc')->lastIndexOf('AB', true));
    }

    public function testEnsurePrefix()
    {
        $this->assertEquals("abc", (string) wstring::from('abc')->ensurePrefix('a'));
        $this->assertEquals("Aabc", (string) wstring::from('abc')->ensurePrefix('A'));
        $this->assertEquals("aAbc", (string) wstring::from('Abc')->ensurePrefix('a'));
        $this->assertEquals("abc", (string) wstring::from('abc')->ensurePrefix('A', true));
        $this->assertEquals("Abc", (string) wstring::from('Abc')->ensurePrefix('a', true));
    }

    public function testEnsureSuffix()
    {
        $this->assertEquals("abc", (string) wstring::from('abc')->ensureSuffix('c'));
        $this->assertEquals("abcC", (string) wstring::from('abc')->ensureSuffix('C'));
        $this->assertEquals("abCc", (string) wstring::from('abC')->ensureSuffix('c'));
        $this->assertEquals("abc", (string) wstring::from('abc')->ensureSuffix('C', true));
        $this->assertEquals("abC", (string) wstring::from('abC')->ensureSuffix('c', true));
    }

    public function testAppend()
    {
        $this->assertEquals("abcdef", (string) wstring::from('abc')->append('def'));
    }

    public function testPrepend()
    {
        $this->assertEquals("abcdef", (string) wstring::from('def')->prepend('abc'));
    }

    public function testInsert()
    {
        $this->assertEquals("x012345", (string) wstring::from('012345')->insert('x', 0));
        $this->assertEquals("x012345", (string) wstring::from('012345')->insert('x', -10));
        $this->assertEquals("012x345", (string) wstring::from('012345')->insert('x', 3));
        $this->assertEquals("0123x45", (string) wstring::from('012345')->insert('x', 4));
        $this->assertEquals("01234x5", (string) wstring::from('012345')->insert('x', 5));
        $this->assertEquals("012345x", (string) wstring::from('012345')->insert('x', 6));
        $this->assertEquals("012345x", (string) wstring::from('012345')->insert('x', 100));
    }

    public function testTrim()
    {
        $this->assertEquals("abc", (string) wstring::from("   \nabc\n\r\t \n")->trim());
    }

    public function testRightTrim()
    {
        $this->assertEquals("   \nabc", (string) wstring::from("   \nabc\n\r\t \n")->trimRight());
    }

    public function testLeftTrim()
    {
        $this->assertEquals("abc\n\r\t \n", (string) wstring::from("   \nabc\n\r\t \n")->trimLeft());
    }

    public function testReplace()
    {
        $this->assertEquals("0x0a0", (string) wstring::from("0a0a0")->replace("a", "x"));
        $this->assertEquals("0a0x0", (string) wstring::from("0a0a0")->replace("a", "x", 2));
    }

    public function testReplaceWithSubjectIsNotInTheSting()
    {
        $this->assertInstanceOf("Opis\String\UnicodeString", wstring::from("0a0a0")->replace("x", "a"));
    }

    public function testReplaceAll()
    {
        $this->assertEquals("0x0x0", (string) wstring::from("0a0a0")->replaceAll("a", "x"));
    }

    public function testReplaceAllWithSubjectIsNotInTheSting()
    {
        $this->assertInstanceOf("Opis\String\UnicodeString", wstring::from("0a0a0")->replaceAll("x", "a"));
    }

    public function testReverse()
    {
        $this->assertEquals("fedcba", (string) wstring::from("abcdef")->reverse());
    }

    public function testRepeat()
    {
        $this->assertEquals("abcabc", (string) wstring::from("abc")->repeat());
        $this->assertEquals("abcabcabcabc", (string) wstring::from("abc")->repeat(3));
        $this->assertEquals("ăĂâÂîÎşŞţŢăĂâÂîÎşŞţŢăĂâÂîÎşŞţŢ", (string) wstring::from("ăĂâÂîÎşŞţŢ")->repeat(2));
    }

    public function testRepeatTimesShouldBeChangedIntoOne()
    {
        $this->assertEquals("abcabc", (string) wstring::from("abc")->repeat(-1));
    }

    public function testRemove()
    {
        $this->assertEquals("ÂîÎşŞţŢ", (string) wstring::from('ăĂâÂîÎşŞţŢ')->remove(0, 3));
        $this->assertEquals("ăĂâÂîÎşŞţ", (string) wstring::from('ăĂâÂîÎşŞţŢ')->remove(9, 3));
        $this->assertEquals("ăĂâÂŞţŢ", (string) wstring::from('ăĂâÂîÎşŞţŢ')->remove(4, 3));
    }

    public function testRemoveIndexLengthShouldBeChangedIntoZero()
    {
        $this->assertEquals("ăĂâÂîÎşŞţŢ", (string) wstring::from('ăĂâÂîÎşŞţŢ')->remove(-1, -1));
    }

    public function testPadLeft()
    {
        $this->assertEquals("xxabc", (string) wstring::from("abc")->padLeft(5, 'x'));
        $this->assertEquals("xyabc", (string) wstring::from("abc")->padLeft(5, 'xyz'));
        $this->assertEquals("xyzxabc", (string) wstring::from("abc")->padLeft(7, 'xyz'));
        $this->assertEquals("", (string) wstring::from("abc")->padLeft(0, 'x'));
        $this->assertEquals("", (string) wstring::from("abc")->padLeft(-1, 'x'));
        $this->assertEquals("c", (string) wstring::from("abc")->padLeft(1, 'x'));
    }

    public function testPadLeftEqualWithStringLength()
    {
        $this->assertInstanceOf("Opis\String\UnicodeString", wstring::from("xxabc")->padLeft(5, 'x'));
    }

    public function testPadLeftWithEmptyPad()
    {
        $this->assertEquals(" xxabc", (string) wstring::from("xxabc")->padLeft(6, ''));
    }

    public function testRight()
    {
        $this->assertEquals("abcxx", (string) wstring::from("abc")->padRight(5, 'x'));
        $this->assertEquals("abcxy", (string) wstring::from("abc")->padRight(5, 'xyz'));
        $this->assertEquals("abcxyzx", (string) wstring::from("abc")->padRight(7, 'xyz'));
        $this->assertEquals("", (string) wstring::from("abc")->padRight(0, 'x'));
        $this->assertEquals("", (string) wstring::from("abc")->padRight(-1, 'x'));
        $this->assertEquals("a", (string) wstring::from("abc")->padRight(1, 'x'));
    }

    public function testSplit()
    {
        $map = function($value){
            return (string) $value;
        };
        $split = function($text, $char = '') use($map){
            return array_map($map, wstring::from($text)->split($char));
        };

        $this->assertEquals(array('a', 'b', 'c'), $split('a|b|c', '|'));
        $this->assertEquals(array('', 'a', 'b', 'c'), $split('|a|b|c', '|'));
        $this->assertEquals(array('', 'a', 'b', 'c', '', ''), $split('|a|b|c||', '|'));
        $this->assertEquals(array('|a|b|c', ''), $split('|a|b|c||', '||'));
        $this->assertEquals(array('a|b|c'), $split('a|b|c', '#'));
        $this->assertEquals(array('a', 'b', 'c'), $split('abc'));
    }

    public function testSubstring()
    {
        $this->assertEquals('abc', wstring::from('abcdef')->substring(0, 3));
        $this->assertEquals('def', wstring::from('abcdef')->substring(3, 3));
        $this->assertEquals('def', wstring::from('abcdef')->substring(3));
        $this->assertEquals('abcdef', wstring::from('abcdef')->substring(0));
    }

    public function testIsCase()
    {
        $this->assertTrue(wstring::from('abcd')->isLowerCase());
        $this->assertFalse(wstring::from('abCd')->isLowerCase());
        $this->assertTrue(wstring::from('ABCD')->isUpperCase());
        $this->assertFalse(wstring::from('ABcD')->isUpperCase());
    }

    public function testToCase()
    {
        $this->assertEquals('ABC', wstring::from('abc')->toUpper());
        $this->assertEquals('ABC', wstring::from('aBc')->toUpper());
        $this->assertEquals('abc', wstring::from('ABC')->toLower());
        $this->assertEquals('abc', wstring::from('AbC')->toLower());
    }

    public function testToLowerWithIsLowerCache()
    {
        $wstr = new wstring(array('UTF-8'), array('abc'));
        $wstr->isLowerCase();
        $this->assertInstanceOf("Opis\String\UnicodeString", $wstr->toLower());
    }

    public function testToUpperWithIsUpperCache()
    {
        $wstr = new wstring(array('UTF-8'), array('abc'));
        $wstr->isUpperCase();
        $this->assertInstanceOf("Opis\String\UnicodeString", $wstr->toUpper());
    }

    public function testToAscii()
    {
        $this->assertEquals("aAaAiIsStT", wstring::from("ăĂâÂîÎşŞţŢ")->toAscii());
    }

    public function testToAsciiWithIsAsciiCache()
    {
        $wstr = new wstring(array('UTF-8'), array('abc'));
        $wstr->isAscii();
        $this->assertInstanceOf("Opis\String\UnicodeString", $wstr->toAscii());
    }

    public function testIsAscii()
    {
        $this->assertTrue(wstring::from('abcde')->isAscii());
        $this->assertFalse(wstring::from('abcîÎşa')->isAscii());
    }

    public function testIsAsciiWithCache()
    {
        $wstr = new wstring(array('UTF-8'), array('abc'));
        $wstr->isAscii();
        $this->assertTrue($wstr->isAscii());
    }

    public function testStringWithExistedCharacter()
    {
        $wstr = new wstring(array('abcd'), array('bcd'));
        $this->assertTrue(isset($wstr[0]));
    }

    public function testStringWithChars()
    {
        $wstr = new wstring(array('abcd'), array('bcd'));
        $this->assertEquals(array('bcd'), $wstr->chars());
    }

    public function testStringWithCodePoints()
    {
        $wstr = new wstring(array('abcd'), array('bcd'));
        $this->assertEquals(array('abcd'), $wstr->codePoints());
    }

    public function testStringOffsetChar()
    {
        $wstr = new wstring(array('abcd'), array('bcd'));
        $this->assertEquals('abcd', $wstr(0));
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Invalid operation
     */
    public function testSetStringShouldReturnInvalidOperation()
    {
        $wstr = new wstring(array('abcd'), array('bcd'));
        $wstr[] = 'a';
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Invalid operation
     */
    public function testUnsetStringShouldReturnInvalidOperation()
    {
        $wstr = new wstring(array('abcd'), array('bcd'));
        unset($wstr[0]);
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Could not convert string from 'error_encoding' encoding to UTF-8 encoding
     */
    public function testFromStringWithInvalidEncoding()
    {
        $wstr = wstring::from('abcd', 'error_encoding');
    }

    public function testFromStringWithE0Character()
    {
        $this->assertEquals("\xE0\xE0\xE0", (string) wstring::from("\xE0\xE0\xE0")->replace("E", "x"));
    }

    public function testFromStringWithF0Character()
    {
        $this->assertEquals("\xF0\xF0\xF0\xF0", (string) wstring::from("\xF0\xF0\xF0\xF0")->replace("F", "x"));
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Invalid UTF-8 string
     */
    public function testFromStringWithInvalidUtf8String()
    {
        wstring::from("\xA0\xA0\xA0\xA0");
    }

}
