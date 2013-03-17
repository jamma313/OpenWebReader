<?php
/**
 * DAO Object representing the table streams_relations
 *
 * PHP 5
 *
 * OWR - OpenWebReader
 *
 * Copyright (c) 2009, Pierre-Alain Mignot
 *
 * Home page: http://openwebreader.org
 *
 * E-Mail: contact@openwebreader.org
 *
 * All Rights Reserved
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * @author Pierre-Alain Mignot <contact@openwebreader.org>
 * @copyright Copyright (c) 2009, Pierre-Alain Mignot
 * @license http://www.gnu.org/copyleft/gpl.html
 * @package OWR
 * @subpackage DAO\streams
 */
namespace OWR\DAO\streams;
use OWR\DAO,
    OWR\DB\Request as DBRequest;
/**
 * This object represents the table streams_relations
 * @uses DAO extends the base class
 * @uses DBRequest defines the fields type
 * @package OWR
 * @subpackage DAO\streams
 */
class Relations extends DAO
{
    /**
     * @var int stream's id
     * @access public
     */
    public $rssid;

    /**
     * @var int user's id
     * @access public
     */
    public $uid;

    /**
     * @var int group's id
     * @access public
     */
    public $gid;

    /**
     * Constructor
     *
     * @access public
     * @author Pierre-Alain Mignot <contact@openwebreader.org>
     */
    public function __construct()
    {
        $this->_uniqueFields = array('rssid'=>true);
        $this->_fields = array(
            'gid'                       => array('required' => true, 'type' => \PDO::PARAM_INT),
            'rssid'                     => array('required' => true, 'type' => \PDO::PARAM_INT),
            'uid'                       => array('required' => true, 'type' => \PDO::PARAM_INT)
        );
        $this->_relations = array(
            'streams'                   => array('rssid'    => 'id'),
        );
        $this->_userRelations = array(
            'streams_groups'            => array('gid'      => 'id'),
            'streams_relations'         => array('rssid'    => 'rssid'),
            'streams_relations_name'    => array('rssid'    => 'rssid'),
            'news_relations'            => array('rssid'    => 'rssid')
        );
        $this->_weight = 8;
        parent::__construct();
    }
}