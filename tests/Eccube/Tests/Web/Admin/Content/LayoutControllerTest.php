<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Tests\Web\Admin\Content;

use Eccube\Entity\Master\DeviceType;
use Eccube\Repository\PageLayoutRepository;
use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Eccube\Repository\LayoutRepository;
use Eccube\Repository\Master\DeviceTypeRepository;
use Eccube\Entity\Layout;
use Eccube\Entity\Page;
use Eccube\Entity\PageLayout;
use Eccube\Repository\PageRepository;

class LayoutControllerTest extends AbstractAdminWebTestCase
{
    /**
     * @var PageLayoutRepository
     */
    private $PageLayoutRepo;

    /**
     * @var LayoutRepository
     */
    protected $layoutRepository;

    /**
     * @var DeviceTypeRepository
     */
    protected $deviceTypeRepository;

    /**
     * @var PageRepository
     */
    protected $pageRepository;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->PageLayoutRepo = $this->container->get(PageLayoutRepository::class);
        $this->layoutRepository = $this->container->get(LayoutRepository::class);
        $this->deviceTypeRepository = $this->container->get(DeviceTypeRepository::class);
        $this->pageRepository = $this->container->get(PageRepository::class);
    }

    public function testIndex()
    {
        $this->client->request('GET', $this->generateUrl('admin_content_layout'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testIndexWithPost()
    {
        $crawler = $this->client->request(
            'POST',
            $this->generateUrl(
                'admin_content_layout_edit',
                ['id' => 1]
            ),
            [
                'form' => [
                    '_token' => 'dummy',
                    'name' => 'テストレイアウト',
                    'DeviceType' => DeviceType::DEVICE_TYPE_PC,
                ],
                'name_1' => 'カゴの中',
                'block_id_1' => 2,
                'section_1' => 2,
                'block_row_1' => 2,
                'name_2' => '商品検索',
                'block_id_2' => 3,
                'section_2' => 3,
                'block_row_2' => 3,
            ]
        );
        $this->assertTrue($this->client->getResponse()->isRedirect(
            $this->generateUrl('admin_content_layout_edit', ['id' => 1])
        ));
    }

    public function testIndexWithNew()
    {
        $this->client->request(
            'GET',
            $this->generateUrl(
                'admin_content_layout_new'
            )
        );
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testIndexWithPostPreview()
    {
        // FIXME プレビュー機能が実装されたら有効にする
        $this->markTestIncomplete('Layout Preview is not implemented.');

        $crawler = $this->client->request(
            'POST',
            $this->app->url(
                'admin_content_layout_preview',
                ['id' => 1]
            ),
            [
                'form' => [
                    '_token' => 'dummy',
                ],
                'name_1' => 'カゴの中',
                'id_1' => 2,
                'section_1' => 2,
                'top_1' => 2,
                'name_2' => '商品検索',
                'id_2' => 3,
                'section_2' => 3,
                'top_2' => 3,
            ]
        );
        $this->assertTrue($this->client->getResponse()->isRedirect(
            $this->app->url('homepage').'?preview=1'
        ));
    }

    public function testDeleteSuccess()
    {
        $PcDeviceType = $this->deviceTypeRepository->find(DeviceType::DEVICE_TYPE_PC);

        $Layout = new Layout();
        $Layout->setName('Layout for unit test');
        $Layout->setDeviceType($PcDeviceType);
        $this->layoutRepository->save($Layout);

        $this->entityManager->flush();

        $this->client->request(
            'DELETE',
            $this->generateUrl('admin_content_layout_delete', ['id' => $Layout->getId()])
        );
        $crawler = $this->client->followRedirect();
        $this->assertRegExp('/削除が完了しました。/u', $crawler->filter('div.alert-success')->text());
    }

    public function testDeleteFail()
    {
        $PcDeviceType = $this->deviceTypeRepository->find(DeviceType::DEVICE_TYPE_PC);
        $Layout = new Layout();
        $Layout->setName('Layout for unit test');
        $Layout->setDeviceType($PcDeviceType);
        $this->layoutRepository->save($Layout);
        $this->entityManager->flush();

        $this->client->request(
            'POST',
            $this->generateUrl('admin_content_layout_delete', ['id' => $Layout->getId()])
        );
        $this->assertEquals(405, $this->client->getResponse()->getStatusCode());

        $this->client->request(
            'DELETE',
            $this->generateUrl('admin_content_layout_delete', ['id' => 0])
        );
        $this->assertTrue($this->client->getResponse()->isNotFound());
    }

    public function testDeleteFailByPages()
    {
        $PcDeviceType = $this->deviceTypeRepository->find(DeviceType::DEVICE_TYPE_PC);

        $Layout = new Layout();
        $Layout->setName('Layout for unit test');
        $Layout->setDeviceType($PcDeviceType);
        $this->layoutRepository->save($Layout);
        $this->entityManager->flush();

        $Page = new Page();
        $Page->setDeviceType($PcDeviceType);
        $Page->setName('Page for unit test');
        $Page->setUrl('layout-test-delete-fail');
        $this->pageRepository->save($Page);
        $this->entityManager->flush();

        $PageLayout = new PageLayout();
        $PageLayout->setLayout($Layout);
        $PageLayout->setLayoutId($Layout->getId());
        $PageLayout->setPage($Page);
        $PageLayout->setPageId($Page->getId());
        $PageLayout->setSortNo(1);
        $this->PageLayoutRepo->save($PageLayout);
        $this->entityManager->flush();

        $Layout->addPageLayout($PageLayout);
        $this->entityManager->flush();

        $this->client->request(
            'DELETE',
            $this->generateUrl('admin_content_layout_delete', ['id' => $Layout->getId()])
        );
        $crawler = $this->client->followRedirect();
        $this->assertRegExp('/既に削除されています。/u', $crawler->filter('div.alert-warning')->text());
    }
}
