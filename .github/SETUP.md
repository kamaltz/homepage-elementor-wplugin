# GitHub Actions Setup

## Required Secrets

1. **PAT_TOKEN**: Personal Access Token dengan permissions:
   - `repo` (full control)
   - `workflow`
   - `write:packages`

2. **WEBHOOK_URL**: URL endpoint untuk WordPress webhook (optional)

## Setup Steps

1. Go to GitHub Settings > Developer settings > Personal access tokens
2. Generate new token with required permissions
3. Add to repository secrets as `PAT_TOKEN`
4. Enable Actions in repository settings
5. Push to main branch to trigger auto-versioning

## How it works

### Auto Build (deploy.yml)
- Push to main → auto-increment version in build
- Creates GitHub release with incremented version
- No git commits from Actions

### Manual Release (release.yml)
- Manual trigger from Actions tab
- Choose version type (patch/minor/major)
- Commits version bump to repo
- Creates tagged release

### Usage
1. **Development**: Push code changes → auto-build with incremented version
2. **Release**: Use manual workflow for official releases with git tags