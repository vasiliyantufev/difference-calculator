<?php

const PATH_FILES = 'tests' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;

const PRETTY = <<<DOC
{
    common: {
        setting1: Value 1
      - setting2: 200
        setting3: false
      - setting6: {
            key: value
        }
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
    }
  + common: {
        setting1: Value 1
        setting3: false
        setting4: blah blah
        setting5: {
            key5: value5
        }
    }
  - common: {
        setting1: Value 1
        setting2: 200
        setting3: false
        setting6: {
            key: value
        }
    }
    group1: {
      + baz: bars
      - baz: bas
        foo: bar
    }
  + group1: {
        foo: bar
        baz: bars
    }
  - group1: {
        baz: bas
        foo: bar
    }
  - group2: {
        abc: 12345
    }
  + group3: {
        fee: 100500
    }
}
DOC;

const PLAIN = <<<DOC
Property 'common.setting2' was removed
Property 'common.setting6' was removed
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: 'complex value'
Property 'group1.baz' was changed. From 'bas' to 'bars'
Property 'group2' was removed
Property 'group3' was added with value: 'complex value'
DOC;
