<?php
declare(strict_types=1);
namespace Controllers;

class SitemapController
{
    const BASE_URL = "https://developerarthurvieira.com.br/src/Views/activity.php?id=";
    private string $sitemapPath = __DIR__."../../../public/sitemap.xml";

    public function CreateActivityXml(int $id): void {
        if(file_exists($this->sitemapPath)){
            $newURL = '<url>
                    <loc>'.self::BASE_URL.$id.'</loc>
                    <lastmod>'.date("Y-m-d").'</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.8</priority>
                 </url>';

            $sitemapContent = file_get_contents($this->sitemapPath);
            $sitemapContent = str_replace('</urlset>', '', $sitemapContent);
            $sitemapContent .= $newURL;
            $sitemapContent .= '</urlset>';

            if(!file_put_contents($this->sitemapPath, $sitemapContent, LOCK_EX)){
                throw new \Exception("Erro ao atualizar sitemap");
            }
        } else {
            throw new \Exception("Sitemap não encontrado");
        }
    }
}