<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfcRbac\Guard;

use Zend\Mvc\MvcEvent;
use ZfcRbac\Service\AuthorizationService;

/**
 * A controller guard can protect a controller and a set of actions
 */
class ControllerGuard extends AbstractGuard
{
    /**
     * Rule prefix that is used to avoid conflicts in the Rbac container
     *
     * Rules will be added to the Rbac container using the following syntax:
     *      __controller__.$controller.$action
     */
    const RULE_PREFIX = '__controller__';

    /**
     * Controller guard rules
     *
     * @var array
     */
    protected $rules = array();

    /**
     * Constructor
     *
     * @param AuthorizationService $authorizationService
     * @param array                $rules
     */
    public function __construct(AuthorizationService $authorizationService, array $rules = array())
    {
        parent::__construct($authorizationService);

        if (!empty($rules)) {
            $this->setRules($rules);
        }
    }

    /**
     * Set the rules (it overrides any existing rules)
     *
     * @param  array $rules
     * @return void
     */
    public function setRules(array $rules)
    {
        $this->rules = array();
        $this->addRules($rules);
    }

    /**
     * Add controller rules
     *
     * A controller rule is made the following way:
     *
     * array(
     *      'controller' => 'ControllerName',
     *      'actions'    => array()/string
     *      'roles'      => array()/string
     * )
     *
     * @param  array $rules
     * @return void
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $controller = strtolower($rule['controller']);
            $actions    = isset($rule['actions']) ? (array) $rule['actions'] : array();
            $roles      = (array) $rule['roles'];

            if (empty($actions)) {
                $this->rules[$controller] = $roles;
                continue;
            }

            foreach ($actions as $action) {
                $action                            = strtolower($action);
                $this->rules[$controller][$action] = $roles;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isGranted(MvcEvent $event)
    {
        $controller = strtolower($event->getRouteMatch()->getParam('controller'));
        $action     = strtolower($event->getRouteMatch()->getParam('action'));

        // If no rules apply, it is considered as granted or not based on the protection policy
        if (!isset($this->rules[$controller])) {
            return $this->protectionPolicy === self::POLICY_DENY ? false : true;
        }

        if (isset($this->rules[$controller][$action])) {
            $allowedRoles = $this->rules[$controller][$action];
            $permission   = self::RULE_PREFIX . '.' . $controller . '.' . $action;
        } else {
            $allowedRoles = $this->rules[$controller];
            $permission   = self::RULE_PREFIX . '.' . $controller;
        }

        // Lazy-load the permission inside the container
        $this->loadRule($allowedRoles, $permission);

        return $this->authorizationService->isGranted($permission);
    }
}
