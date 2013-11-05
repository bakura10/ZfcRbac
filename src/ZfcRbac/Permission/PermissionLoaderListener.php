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

namespace ZfcRbac\Permission;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZfcRbac\Permission\PermissionProviderInterface;
use ZfcRbac\Service\RbacEvent;

/**
 * Simple listener that is used to load permissions
 */
class PermissionLoaderListener extends AbstractListenerAggregate
{
    /**
     * @var PermissionProviderInterface
     */
    protected $permissionProvider;

    /**
     * Constructor
     *
     * @param PermissionProviderInterface $permissionProvider
     */
    public function __construct(PermissionProviderInterface $permissionProvider)
    {
        $this->permissionProvider = $permissionProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEventManager = $events->getSharedManager();

        $sharedEventManager->attach(
            'ZfcRbac',
            RbacEvent::EVENT_LOAD_PERMISSIONS,
            array($this, 'onLoadPermissions')
        );
    }

    /**
     * Inject the loaded permissions inside the Rbac container
     *
     * @param  RbacEvent $event
     * @return void
     */
    public function onLoadPermissions(RbacEvent $event)
    {
        // @TODO: add a cache for permissions. However, we must have a way to easily disable it, because some
        // complex providers that lazy-load permissions may play badly with this caching feature. It's something
        // we must carefully think about

        $rbac        = $event->getRbac();
        $permissions = $this->permissionProvider->getPermissions($event);

        foreach ($permissions as $role => $subPermissions) {
            $role           = $rbac->getRole($role);
            $subPermissions = (array) $subPermissions;

            foreach ($subPermissions as $permission) {
                $role->addPermission($permission);
            }
        }
    }
}
