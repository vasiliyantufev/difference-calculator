<?php

namespace DifferenceCalculator\Structure;

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

const JSON = <<<DOC
[
    {
        "type": "nested",
        "name": "common",
        "children": [
            {
                "type": "unchanged",
                "node": "setting1",
                "before": "Value 1",
                "after": "Value 1"
            },
            {
                "type": "removed",
                "node": "setting2",
                "before": "200",
                "after": ""
            },
            {
                "type": "unchanged",
                "node": "setting3",
                "before": false,
                "after": false
            },
            {
                "type": "removed",
                "node": "setting6",
                "before": {
                    "key": "value"
                },
                "after": ""
            },
            {
                "type": "added",
                "node": "setting4",
                "before": "",
                "after": "blah blah"
            },
            {
                "type": "added",
                "node": "setting5",
                "before": "",
                "after": {
                    "key5": "value5"
                }
            }
        ]
    },
    {
        "type": "changed",
        "node": "common",
        "before": {
            "setting1": "Value 1",
            "setting2": "200",
            "setting3": false,
            "setting6": {
                "key": "value"
            }
        },
        "after": {
            "setting1": "Value 1",
            "setting3": false,
            "setting4": "blah blah",
            "setting5": {
                "key5": "value5"
            }
        }
    },
    {
        "type": "nested",
        "name": "group1",
        "children": [
            {
                "type": "changed",
                "node": "baz",
                "before": "bas",
                "after": "bars"
            },
            {
                "type": "unchanged",
                "node": "foo",
                "before": "bar",
                "after": "bar"
            }
        ]
    },
    {
        "type": "changed",
        "node": "group1",
        "before": {
            "baz": "bas",
            "foo": "bar"
        },
        "after": {
            "foo": "bar",
            "baz": "bars"
        }
    },
    {
        "type": "removed",
        "node": "group2",
        "before": {
            "abc": "12345"
        },
        "after": ""
    },
    {
        "type": "added",
        "node": "group3",
        "before": "",
        "after": {
            "fee": "100500"
        }
    }
]
DOC;

const YAML_JSON = <<<DOC
[
    {
        "type": "unchanged",
        "node": "integer",
        "before": 25,
        "after": 25
    },
    {
        "type": "changed",
        "node": "string",
        "before": "30",
        "after": "25"
    },
    {
        "type": "changed",
        "node": "float",
        "before": 30,
        "after": 25
    },
    {
        "type": "changed",
        "node": "boolean",
        "before": "no",
        "after": "Yes"
    }
]
DOC;
