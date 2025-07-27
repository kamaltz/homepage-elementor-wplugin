#!/usr/bin/env node

const fs = require('fs');
const path = require('path');

const version = process.argv[2];
if (!version) {
    console.error('Usage: node bump-version.js <version>');
    process.exit(1);
}

// Update main plugin file
const pluginFile = path.join(__dirname, '..', 'homepage-elementor.php');
let content = fs.readFileSync(pluginFile, 'utf8');
content = content.replace(/Version: [\d.]+/, `Version: ${version}`);
content = content.replace(/new Homepage_Elementor_Updater\(__FILE__, '[^']+'\)/, `new Homepage_Elementor_Updater(__FILE__, '${version}')`);
fs.writeFileSync(pluginFile, content);

// Update README
const readmeFile = path.join(__dirname, '..', 'README.md');
let readme = fs.readFileSync(readmeFile, 'utf8');
readme = readme.replace(/## Version [\d.]+/, `## Version ${version}`);
fs.writeFileSync(readmeFile, readme);

console.log(`Version bumped to ${version}`);