<?php

namespace Providers;

class RequestProvider
{
    public static function requestProvider()
    {
        return array(array(
            array(
                'X-Hub-Signature' => 'sha1=f1ed3c1c6208a4b1911bf3fdd34f4a5cbb9eb26c',
            ),
            '{"ref":"refs/heads/master","before":"f73385816155774f248f14816a434fb9e3e80169","after":"38ac58b2eebfc1a9cd3eee4e2887c3ff5622c958","created":false,"deleted":false,"forced":false,"base_ref":null,"compare":"https://github.com/roundpartner/deploy/compare/f73385816155...38ac58b2eebf","commits":[{"id":"38ac58b2eebfc1a9cd3eee4e2887c3ff5622c958","distinct":true,"message":"Adding comment","timestamp":"2016-02-27T14:25:31Z","url":"https://github.com/roundpartner/deploy/commit/38ac58b2eebfc1a9cd3eee4e2887c3ff5622c958","author":{"name":"Tom Lorentsen","email":"tom@thomaslorentsen.co.uk","username":"thomaslorentsen"},"committer":{"name":"Tom Lorentsen","email":"tom@thomaslorentsen.co.uk","username":"thomaslorentsen"},"added":[],"removed":[],"modified":["tests/unit/DeployTest.php"]}],"head_commit":{"id":"38ac58b2eebfc1a9cd3eee4e2887c3ff5622c958","distinct":true,"message":"Adding comment","timestamp":"2016-02-27T14:25:31Z","url":"https://github.com/roundpartner/deploy/commit/38ac58b2eebfc1a9cd3eee4e2887c3ff5622c958","author":{"name":"Tom Lorentsen","email":"tom@thomaslorentsen.co.uk","username":"thomaslorentsen"},"committer":{"name":"Tom Lorentsen","email":"tom@thomaslorentsen.co.uk","username":"thomaslorentsen"},"added":[],"removed":[],"modified":["tests/unit/DeployTest.php"]},"repository":{"id":52612292,"name":"deploy","full_name":"roundpartner/deploy","owner":{"name":"roundpartner","email":"tom@roundpartner.co.uk"},"private":true,"html_url":"https://github.com/roundpartner/deploy","description":"Deployment Scripts","fork":false,"url":"https://github.com/roundpartner/deploy","forks_url":"https://api.github.com/repos/roundpartner/deploy/forks","keys_url":"https://api.github.com/repos/roundpartner/deploy/keys{/key_id}","collaborators_url":"https://api.github.com/repos/roundpartner/deploy/collaborators{/collaborator}","teams_url":"https://api.github.com/repos/roundpartner/deploy/teams","hooks_url":"https://api.github.com/repos/roundpartner/deploy/hooks","issue_events_url":"https://api.github.com/repos/roundpartner/deploy/issues/events{/number}","events_url":"https://api.github.com/repos/roundpartner/deploy/events","assignees_url":"https://api.github.com/repos/roundpartner/deploy/assignees{/user}","branches_url":"https://api.github.com/repos/roundpartner/deploy/branches{/branch}","tags_url":"https://api.github.com/repos/roundpartner/deploy/tags","blobs_url":"https://api.github.com/repos/roundpartner/deploy/git/blobs{/sha}","git_tags_url":"https://api.github.com/repos/roundpartner/deploy/git/tags{/sha}","git_refs_url":"https://api.github.com/repos/roundpartner/deploy/git/refs{/sha}","trees_url":"https://api.github.com/repos/roundpartner/deploy/git/trees{/sha}","statuses_url":"https://api.github.com/repos/roundpartner/deploy/statuses/{sha}","languages_url":"https://api.github.com/repos/roundpartner/deploy/languages","stargazers_url":"https://api.github.com/repos/roundpartner/deploy/stargazers","contributors_url":"https://api.github.com/repos/roundpartner/deploy/contributors","subscribers_url":"https://api.github.com/repos/roundpartner/deploy/subscribers","subscription_url":"https://api.github.com/repos/roundpartner/deploy/subscription","commits_url":"https://api.github.com/repos/roundpartner/deploy/commits{/sha}","git_commits_url":"https://api.github.com/repos/roundpartner/deploy/git/commits{/sha}","comments_url":"https://api.github.com/repos/roundpartner/deploy/comments{/number}","issue_comment_url":"https://api.github.com/repos/roundpartner/deploy/issues/comments{/number}","contents_url":"https://api.github.com/repos/roundpartner/deploy/contents/{+path}","compare_url":"https://api.github.com/repos/roundpartner/deploy/compare/{base}...{head}","merges_url":"https://api.github.com/repos/roundpartner/deploy/merges","archive_url":"https://api.github.com/repos/roundpartner/deploy/{archive_format}{/ref}","downloads_url":"https://api.github.com/repos/roundpartner/deploy/downloads","issues_url":"https://api.github.com/repos/roundpartner/deploy/issues{/number}","pulls_url":"https://api.github.com/repos/roundpartner/deploy/pulls{/number}","milestones_url":"https://api.github.com/repos/roundpartner/deploy/milestones{/number}","notifications_url":"https://api.github.com/repos/roundpartner/deploy/notifications{?since,all,participating}","labels_url":"https://api.github.com/repos/roundpartner/deploy/labels{/name}","releases_url":"https://api.github.com/repos/roundpartner/deploy/releases{/id}","deployments_url":"https://api.github.com/repos/roundpartner/deploy/deployments","created_at":1456499364,"updated_at":"2016-02-26T18:34:08Z","pushed_at":1456583137,"git_url":"git://github.com/roundpartner/deploy.git","ssh_url":"git@github.com:roundpartner/deploy.git","clone_url":"https://github.com/roundpartner/deploy.git","svn_url":"https://github.com/roundpartner/deploy","homepage":null,"size":4,"stargazers_count":0,"watchers_count":0,"language":"PHP","has_issues":true,"has_downloads":true,"has_wiki":true,"has_pages":false,"forks_count":0,"mirror_url":null,"open_issues_count":0,"forks":0,"open_issues":0,"watchers":0,"default_branch":"master","stargazers":0,"master_branch":"master","organization":"roundpartner"},"pusher":{"name":"thomaslorentsen","email":"tom@thomaslorentsen.co.uk"},"organization":{"login":"roundpartner","id":17318167,"url":"https://api.github.com/orgs/roundpartner","repos_url":"https://api.github.com/orgs/roundpartner/repos","events_url":"https://api.github.com/orgs/roundpartner/events","hooks_url":"https://api.github.com/orgs/roundpartner/hooks","issues_url":"https://api.github.com/orgs/roundpartner/issues","members_url":"https://api.github.com/orgs/roundpartner/members{/member}","public_members_url":"https://api.github.com/orgs/roundpartner/public_members{/member}","avatar_url":"https://avatars.githubusercontent.com/u/17318167?v=3","description":""},"sender":{"login":"thomaslorentsen","id":11646737,"avatar_url":"https://avatars.githubusercontent.com/u/11646737?v=3","gravatar_id":"","url":"https://api.github.com/users/thomaslorentsen","html_url":"https://github.com/thomaslorentsen","followers_url":"https://api.github.com/users/thomaslorentsen/followers","following_url":"https://api.github.com/users/thomaslorentsen/following{/other_user}","gists_url":"https://api.github.com/users/thomaslorentsen/gists{/gist_id}","starred_url":"https://api.github.com/users/thomaslorentsen/starred{/owner}{/repo}","subscriptions_url":"https://api.github.com/users/thomaslorentsen/subscriptions","organizations_url":"https://api.github.com/users/thomaslorentsen/orgs","repos_url":"https://api.github.com/users/thomaslorentsen/repos","events_url":"https://api.github.com/users/thomaslorentsen/events{/privacy}","received_events_url":"https://api.github.com/users/thomaslorentsen/received_events","type":"User","site_admin":false}}',
            'myverysecuretestkey'
        ));
    }

}