<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219123927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Добавляем сортировку для помещений';
    }
    
    public function up(Schema $schema): void
    {
        $locations = [
            'на кухню',
            'в комнату',
            'на балкон',
            'в гостиную',
            'в спальню',
            'в квартиру',
            'для дома',
            'для кабинета',
            'на окна в офис',
            'с электроприводом',
            'с рисунком',
            'с фотопечатью',
            'на балконную дверь',
            'для дачи',
            'для террасы',
            'для кафе',
            'на большое окно',
            'на мансардные окна',
            'наружные  на окна',
            'для лоджии',
            'на треугольные окна',
            'арочные',
            'для витрин',
            'для школы',
            'в зал',
            'в детскую комнату',
            'для беседок и веранд',
            'для ванной комнаты на окна',
            'для домашних окон',
            'для ресторана',
            'с логотипом компании',
            'в туалете',
            'для шкафа',
            'для дверных проемов',
            'на веранду',
            'сантехнические',
            'защитные',
            'в кладовку',
        ];
        foreach ($locations as $ordering => $name) {
            $this->addSql('update page set ordering = ? where name like ? and page_type = ?',[
                $ordering +1,
                '%'.$name.'%',
                'location'
            ]);
        }
        //Остальные ставим после последнего элемента
        $this->addSql('update page set ordering = ? where ordering = 0 and page_type = ?',[
            $ordering +1,
            'location'
        ]);
    }
    
    public function down(Schema $schema): void
    {
    
    }
}
