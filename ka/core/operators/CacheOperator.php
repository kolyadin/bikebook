<?php
interface CacheOperator
{
	public function useCache();
	public function cleanCache();
}