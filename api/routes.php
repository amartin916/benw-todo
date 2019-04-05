<?php
return [
  ['GET', '/api/todo', 'getAll'],
  ['POST', '/api/todo', 'createOne'],
  ['GET', '/api/todo/{id}', 'getOne'],
  ['PATCH', '/api/todo/{id}', 'updateOne'],
  ['DELETE', '/api/todo/{id}', 'deleteOne'],
];
