#!/usr/bin/env node

const program = require('commander');

const createProjectStructure = (projectPath, projectName) => {
    try {
        const dirs = [
            'src',
            'src/components',
            'src/services',
            'public',
            'public/assets'
        ];
        
        dirs.forEach(dir => {
            fs.mkdirSync(path.join(projectPath, dir), { recursive: true });
        });

        // Create a basic README file
        fs.writeFileSync(
            path.join(projectPath, 'README.md'),
            `# ${projectName}\n\nThis is your project README.`
        );

        // Create a basic index file
        fs.writeFileSync(
            path.join(projectPath, 'src', 'index.js'),
            `console.log('Welcome to ${projectName}');`
        );

        console.log(`Project ${projectName} initialized successfully at ${projectPath}.`);
    } catch (error) {
        console.error(`Error creating project structure: ${error.message}`);
    }
};

program
  .version('1.0.0')
  .description('scarpa')

// --greet --name
program
  .option('-n, --name <name>', 'Your name')
  .option('-g, --greet', 'Greet the user')
  .parse(process.argv);

// inits project
program
    .command('init <projectName> [projectDir]')
    .description('Initialize ScarpaPHP project with a given project namein a separate directory from cwd or current directory')
    .action((projectName, projectDir) => {
        let projectPath;
        
        if (projectDir === '.') {
            projectPath = path.join(process.cwd(), projectName);
            fs.mkdirSync(projectPath, { recursive: true });
        } else {
            projectPath = path.join(process.cwd(), projectName);
            fs.mkdirSync(projectPath, { recursive: true });
        }

        createProjectStructure(projectPath, projectName);
    });

program.parse(process.argv);

if (!process.argv.slice(2).length) {
    program.outputHelp();
}

// const options = program.opts();

// if (options.greet && options.name) {
//   console.log(`Hello, ${options.name}!`);

// } else if (options.greet) {
//   console.log('Hello!');

// } else {
//   console.log('Run with --greet and --name to get a greeting!');
// }
