<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2012, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

/**
 * This class provides a simple way to load all required analyzers by class,
 * implemented interface or parent class.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 1.0.7
 * @link       http://pdepend.org/
 */
class PHP_Depend_Metrics_AnalyzerLoader implements IteratorAggregate
{
    /**
     * All matching analyzer instances.
     *
     * @var PHP_Depend_Metrics_AnalyzerI[]
     */
    private $_analyzers;
    
    private $_acceptedTypes;

    private $_options;

    /**
     * The system wide used cache.
     *
     * @var PHP_Depend_Util_Cache_Driver
     * @since 1.0.0
     */
    private $_cache;

    /**
     * Used locator for installed analyzer classes.
     *
     * @var PHP_Depend_Metrics_AnalyzerClassLocator
     */
    private $_classLocator;

    /**
     * Constructs a new analyzer loader.
     *
     * @param PHP_Depend_Metrics_AnalyzerClassLocator $classLocator  Class locator
     *        used to find analyzer source files on the current system.
     * @param PHP_Depend_Util_Cache_Driver            $cache         The cache
     *        driver may be used by some analyzers to store calculated metrics.
     * @param array                                   $acceptedTypes This property
     *        contains the class names of the required analyzer.
     * @param array                                   $options       Array with
     *        additional options supplied on the command line.
     */
    public function __construct(
        PHP_Depend_Metrics_AnalyzerClassLocator $classLocator,
        PHP_Depend_Util_Cache_Driver $cache,
        array $acceptedTypes,
        array $options = array()
    ) {
        $this->_cache        = $cache;
        $this->_classLocator = $classLocator;

        $this->_options       = $options;
        $this->_acceptedTypes = $acceptedTypes;
    }

    /**
     * Returns a countable iterator of {@link PHP_Depend_Metrics_AnalyzerI}
     * instances that match against the given accepted types.
     *
     * @return Iterator
     */
    public function getIterator()
    {
        if ($this->_analyzers === null) {
            $this->_initAnalyzers();
        }
        return new PHP_Depend_Metrics_AnalyzerIterator($this->_analyzers);
    }

    /**
     * Initializes all accepted analyzers.
     *
     * @return void
     * @since 0.9.10
     */
    private function _initAnalyzers()
    {
        $this->_analyzers = array();
        $this->_loadAcceptedAnalyzers($this->_acceptedTypes);
    }

    /**
     * Loads all accepted node analyzers.
     *
     * @param array $acceptedTypes Accepted/expected analyzer types.
     *
     * @return PHP_Depend_Metrics_AnalyzerI
     */
    private function _loadAcceptedAnalyzers(array $acceptedTypes)
    {
        $analyzers = array();
        foreach ($this->_classLocator->findAll() as $reflection) {
            if ($this->_isInstanceOf($reflection, $acceptedTypes)) {
                $analyzers[] = $this->_createOrReturnAnalyzer($reflection);
            }
        }
        return $analyzers;
    }

    /**
     * This method checks if the given analyzer class implements one of the
     * expected analyzer types.
     *
     * @param ReflectionClass $reflection    Reflection class for an analyzer.
     * @param array           $expectedTypes List of accepted analyzer types.
     *
     * @return boolean
     * @since 0.9.10
     */
    private function _isInstanceOf(ReflectionClass $reflection, array $expectedTypes)
    {
        foreach ($expectedTypes as $type) {
            if (interface_exists($type) && $reflection->implementsInterface($type)) {
                return true;
            }
            if (class_exists($type) && $reflection->isSubclassOf($type)) {
                return true;
            }
            if (strcasecmp($reflection->getName(), $type) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * This method creates a new analyzer instance or returns a previously
     * created instance of the given reflection instance.
     *
     * @param ReflectionClass $reflection Reflection class for an analyzer.
     *
     * @return PHP_Depend_Metrics_AnalyzerI
     * @since 0.9.10
     */
    private function _createOrReturnAnalyzer(ReflectionClass $reflection)
    {
        $name = $reflection->getName();
        if (!isset($this->_analyzers[$name])) {
            $this->_analyzers[$name] = $this->_createAndConfigure($reflection);
        }
        return $this->_analyzers[$name];
    }

    /**
     * Creates an analyzer instance of the given reflection class instance.
     *
     * @param ReflectionClass $reflection Reflection class for an analyzer.
     *
     * @return PHP_Depend_Metrics_AnalyzerI
     * @since 0.9.10
     */
    private function _createAndConfigure(ReflectionClass $reflection)
    {
        if ($reflection->getConstructor()) {
            $analyzer = $reflection->newInstance($this->_options);
        } else {
            $analyzer = $reflection->newInstance();
        }
        return $this->_configure($analyzer);
    }

    /**
     * Initializes the given analyzer instance.
     *
     * @param PHP_Depend_Metrics_AnalyzerI $analyzer Context analyzer instance.
     *
     * @return PHP_Depend_Metrics_AnalyzerI
     * @since 0.9.10
     */
    private function _configure(PHP_Depend_Metrics_AnalyzerI $analyzer)
    {
        if ($analyzer instanceof PHP_Depend_Metrics_CacheAware) {
            $analyzer->setCache($this->_cache);
        }

        if (!($analyzer instanceof PHP_Depend_Metrics_AggregateAnalyzerI)) {
            return $analyzer;
        }
        
        $required = $this->_loadAcceptedAnalyzers($analyzer->getRequiredAnalyzers());
        foreach ($required as $requiredAnalyzer) {
            $analyzer->addAnalyzer($requiredAnalyzer);
        }
        return $analyzer;
    }
}
