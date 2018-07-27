<?php
/**
 * Return nav-here if current path is this path.
 *
 * @param string $path
 * @return string
 */
function setActive($path)
{
	return Request::is($path) ? ' active' :  '';
}
/**
 * Return nav-here if current path begins with this path.
 *
 * @param string $path
 * @return string
 */
function setActiveParent($path)
{
	return Request::is(substr($path, 1) . '*') ? ' active' :  '';
}
/**
 * Return nav-here if current path begins with this path.
 *
 * @param string $path
 * @return string
 */
function setInnerActive($path)
{
	return Request::is(substr($path, 1));
}