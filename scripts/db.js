// eslint-disable-next-line import/no-extraneous-dependencies
import dotenv from 'dotenv';
// eslint-disable-next-line import/no-extraneous-dependencies
import mysql from 'promise-mysql';

// dotenv setup
dotenv.config();

// Returns a promise with the connection/error
function connection(root) {
  const opts = {};
  opts.host = process.env.DB_HOST;

  if (root) {
    opts.user = process.env.ROOT_DB_USER;

    if (process.env.ROOT_DB_PASSWORD) {
      opts.password = process.env.ROOT_DB_PASSWORD;
    }
  } else {
    opts.user = process.env.DB_USER;
    opts.password = process.env.DB_PASSWORD;
    opts.database = process.env.DB_NAME;
  }

  return mysql.createConnection(opts);
}

function create(conn) {
  const { env } = process;

  return Promise.all([
    conn.query(`CREATE DATABASE ${env.DB_NAME};`),
    conn.query(`CREATE USER '${env.DB_USER}'@'${env.DB_HOST}' IDENTIFIED BY '${env.DB_PASSWORD}';`),
    conn.query(`GRANT ALL PRIVILEGES ON ${env.DB_NAME}.* TO '${env.DB_USER}'@'${env.DB_HOST}';`),
    conn.query('FLUSH PRIVILEGES;'),
  ]);
}

function remove(conn) {
  const { env } = process;

  return Promise.all([
    conn.query(`DROP DATABASE ${env.DB_NAME};`),
    conn.query(`DROP USER '${env.DB_USER}'@'${env.DB_HOST}';`),
  ]);
}

function cli(arg) {
  switch (arg) {
  case 'create':
    return connection(true)
      .then(create);
  case 'remove':
    return connection(true)
      .then(remove);
  default:
    return new Promise(() => 'Usage:\n yarn run db -- (create | remove)');
  }
}

// Init
cli(process.argv[2])
  .then(() => {
    console.log('Queries executed!');
  })
  .catch((err) => {
    console.log(err);
    process.exit(1);
  });
