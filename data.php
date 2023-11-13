<?php

class IDGenerator
{
    private const CHARS = 'ACDEFGHJKMNPQRSTUVWXYZ'.'23479';

    public static function generate(int $len): string
    {
        $id = '';

        $charsLen = strlen(self::CHARS);

        for ($i = 0; $i < $len; $i++)
        {
            $id .= self::CHARS[rand(0, $charsLen-1)];
        }

        return $id;
    }
}

interface Data
{
    public function shortUrl(string $url): string;
    public function getUrl(string $urlID): string | false;
}

class JsonData implements Data
{
    public function __construct(
        private string $dataDir = __DIR__.'/json_data'
    )
    {
        if (!is_dir($dataDir))
        {
            mkdir($dataDir, recursive: true);
        }
    }

    public function shortUrl(string $url): string
    {
        $id = IDGenerator::generate(6);

        $filePath = $this->getFilePath($id);
        $shortUrl = ShortUrl::fromID($id);

        $data = [
            'url' => $url
        ];

        file_put_contents($filePath, json_encode($data));

        return $shortUrl;
    }

    public function getUrl(string $id): string | false
    {
        $filePath = $this->getFilePath(strtoupper($id));

        if (!file_exists($filePath))
        {
            return false;
        }

        $data = json_decode(file_get_contents($filePath), true);

        return $data['url'];
    }

    private function getFilePath(string $id): string
    {
        return $this->dataDir.'/'.$id.'.json';
    }
}

class ShortUrl
{
    public static function fromID(string $id): string
    {
        return 'http://'.$_SERVER['HTTP_HOST'].'/?'.$id;
    }

    public static function getIDFromRequest(): string | false
    {
        if (count($_GET) != 1)
        {
            return false;
        }

        return array_keys($_GET)[0];
    }
}
