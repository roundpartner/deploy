<?php

namespace Providers;

use RoundPartner\Deploy\Entity\Commit;
use RoundPartner\Deploy\Entity\Repository;
use RoundPartner\Deploy\Entity\Request;
use RoundPartner\Deploy\RequestFactory;
use RoundPartner\VerifyHash\VerifyHash;

class RequestProvider
{
    const SECRET = 'myverysecuretestkey';

    public static function requestProvider()
    {
        $request = new Request();
        $request->ref = 'refs/heads/master';
        $request->commits = [self::generateCommit()];
        $request->head_commit = self::generateCommit();
        $request->repository = new Repository();
        $request->repository->full_name = 'symfony/yaml';
        $request->repository->id = 52612292;
        $request->repository->name = 'deploy';
        $request->repository->owner = null;
        $request = RequestFactory::createRequest($request);
        $body = json_encode($request);

        return array(array(
            array(
                'X-Hub-Signature' => self::getHash($body),
                'X-GitHub-Event' => 'push',
            ),
            $body,
            self::SECRET
        ));
    }

    /**
     * @return Commit
     */
    public static function generateCommit()
    {
        $commit = new Commit();
        $commit->id = 12345;
        return $commit;
    }

    public static function getHash($body)
    {
        $verifyHash = new VerifyHash(self::SECRET);
        $hash = $verifyHash->hash($body);
        return "sha1={$hash}";
    }

}