<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Calculator;
use App\Entity\Catalog;
use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Config;
use App\Entity\Location;
use App\Entity\Markiz;
use App\Entity\Material;
use App\Entity\Product;
use App\Entity\Roll;
use App\Entity\Roman;
use App\Entity\Simple;
use App\Entity\Subdomain;
use App\Entity\Type;
use App\Entity\WorkExample;
use App\Field\CKEditorField;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        
        return $this->redirect($routeBuilder->setController(CatalogCrudController::class)->generateUrl());
    }
    
    public function configureAssets(): Assets
    {
        return Assets::new()
                     ->addCssFile('css/admin.css')
                     ->addCssFile('css/chosen.css')
                     ->addCssFile('css/jquery.dm-uploader.css')
                     ->addJsFile('js/cache_clear.js')
                     ->addJsFile('js/chosen.jquery.min.js')
                     ->addJsFile('js/chosen-select.js')
                     ->addJsFile('js/bs-custom-file-input.min.js');
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Админ-панель')
            ->renderContentMaximized()
            ->disableUrlSignatures();
    }
    
    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(100)
            ->setPaginatorRangeSize(10)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
    
    public function configureMenuItems(): iterable
    {
        $submenu1 = [
            MenuItem::linktoRoute('Товары', 'fas fa-file-alt', 'admin_product_import'),
            MenuItem::linktoRoute('Обновление цен', 'fas fa-calculator', 'admin_update_prices'),
            MenuItem::linktoRoute('Обновление title', 'fas fa-cog', 'admin_change_page_titles'),
            MenuItem::linktoRoute('Помещения', 'fas fa-file-alt', 'admin_locations_import'),
        ];
        $submenu2 = [
            MenuItem::linktoRoute('Товары', 'fas fa-file-alt', 'admin_product_export'),
        ];
    
        yield MenuItem::linkToCrud('Примеры работ', 'fas fa-briefcase', WorkExample::class);
        yield MenuItem::section('Страницы');
        yield MenuItem::linkToCrud('Каталоги', 'fas fa-file-alt', Catalog::class);
        yield MenuItem::linkToCrud('Товары', 'fas fa-file-alt', Product::class);
        yield MenuItem::linkToCrud('Помещения', 'fas fa-file-alt', Location::class);
        yield MenuItem::linkToCrud('Маркизы', 'fas fa-file-alt', Markiz::class);
        yield MenuItem::linkToCrud('Рольставни', 'fas fa-file-alt', Roll::class);
        yield MenuItem::linkToCrud('Римские шторы', 'fas fa-file-alt', Roman::class);
        yield MenuItem::linkToCrud('Простые страницы', 'fas fa-file-alt', Simple::class);
        yield MenuItem::linkToCrud('Калькуляторы', 'fas fa-calculator', Calculator::class);
        yield MenuItem::linkToCrud('Статьи', 'fas fa-file', Article::class);
        yield MenuItem::section('Характеристики товаров');
        yield MenuItem::linkToCrud('Типы', 'fas fa-file-alt', Type::class);
        yield MenuItem::linkToCrud('Цвета', 'fas fa-file-alt', Color::class);
        yield MenuItem::linkToCrud('Подтипы', 'fas fa-file-alt', Material::class);
        yield MenuItem::linkToCrud('Категории', 'fas fa-file-alt', Category::class);
        yield MenuItem::section('Технические ссылки');
        yield MenuItem::linkToCrud('Настройки', 'fas fa-cogs', Config::class);
        yield MenuItem::linkToCrud('Поддомены', 'fas fa-globe', Subdomain::class);
        yield MenuItem::linktoRoute('Генератор', 'fas fa-cogs', 'admin_generator_index');
        yield MenuItem::linktoRoute('Изменение URI', 'fas fa-chain', 'admin_change_uri');
        yield MenuItem::subMenu('Импорт', 'fas fa-file-import')->setSubItems($submenu1);
        yield MenuItem::subMenu('Экспорт', 'fas fa-file-export')->setSubItems($submenu2);
    }
    
    public static function getMainBlock(): array
    {
        $name = TextField::new('name', 'Название');
        $uri       = TextField::new('uri', 'Ссылка');
        $parent    = AssociationField::new('parent', 'Родитель');
        $published = Field::new('published', 'Опубликован');
        $mainPanel = FormField::addPanel('Основные')->collapsible();
        
        return [
            $mainPanel,
            $name,
            $uri,
            $parent,
            $published,
        ];
    }
    
    public static function getSeoBlock(): array
    {
        $title        = TextField::new('title', 'Заголовок страницы');
        $h1           = TextField::new('h1', 'H1');
        $description  = TextareaField::new('description', 'Мета-описание');
        $showSeoText  = Field::new('showSeoText', 'SEO-текст');
        $content      = CKEditorField::new('content', 'SEO-текст');
        $seoImageFile = VichImageField::new('seoImageFile', 'SEO-Изображение');
        $priority = Field::new('priority', 'Приоритет в Sitemap');
        $seoPanel     = FormField::addPanel('SEO')->collapsible();
    
        return [
            $seoPanel,
            $title,
            $h1,
            $description,
            $showSeoText,
            $content,
            $seoImageFile,
            $priority,
        ];
    }
    
    public static function getCardBlock(): array
    {
        $cardDescription = CKEditorField::new('cardDescription', 'Описание в карточке');
        $cardImageFile   = VichImageField::new('cardImageFile', 'Изображение в карточке');
        
        $cardPanel = FormField::addPanel('Карточка')->collapsible();
        
        return [
            $cardPanel,
            $cardDescription,
            $cardImageFile,
        ];
    }
}
