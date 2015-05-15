<?php
return array (
  'user' => 
  array (
    'type' => 2,
    'description' => 'just for fun',
    'bizRule' => '',
    'data' => '',
  ),
  'manager' => 
  array (
    'type' => 2,
    'description' => 'Can post a comment',
    'bizRule' => '',
    'data' => '',
  ),
  'admin' => 
  array (
    'type' => 2,
    'description' => 'Can read a post and post a comment',
    'bizRule' => '',
    'data' => '',
    'children' => 
    array (
      0 => 'user',
      1 => 'manager',
    ),
  ),
);
