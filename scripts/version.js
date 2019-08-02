import fs from 'fs';
import pjson from '../package.json';

const version = process.argv[2];

function updateVersion() {
  pjson.version = version;
  const pjsonStr = `${JSON.stringify(pjson, null, 4)}\n`;

  // eslint-disable-next-line consistent-return
  return fs.writeFile('./package.json', pjsonStr, (err) => {
    if (err) {
      return console.log(err);
    }

    console.log(`Version set to ${version}`);
  });
}

if (version) {
  // If version is specificed then set it
  updateVersion(version);
} else {
  // Otherwise returen the current version
  console.log(pjson.version);
}
