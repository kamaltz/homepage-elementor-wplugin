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

- Every push to main → auto-increment patch version
- Creates git tag and GitHub release
- Builds plugin zip file
- Notifies WordPress sites via webhook