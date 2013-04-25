<?php namespace JMetaBox;

/**
 * FieldInterface
 *
 * @author Josh Mahony (jalmahony@gmail.com)
 **/
interface FieldInterface {

  /**
   * save
   * MetaBox needs this when iterating over fields and saving them
   **/
  function save();

  /**
   * enqueueScripts
   * Needs to be public so WordPress can call this when enqueing scripts
   **/
  function enqueueScripts();

  /**
   * enqueueStyles
   * Needs to be public so WordPress can call this when enqueing styles
   **/
  function enqueueStyles();

  /**
   * getId
   * Return fields identifier
   **/
  function getId();

  /**
   * getMetaBox
   * Returns the fields containing metabox
   **/
  function getMetaBox();

}
