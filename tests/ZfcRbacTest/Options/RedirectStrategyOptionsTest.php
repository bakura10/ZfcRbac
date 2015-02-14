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

namespace ZfcRbacTest;

use ZfcRbac\Options\RedirectStrategyOptions;

/**
 * @covers \ZfcRbac\Options\RedirectStrategyOptions
 */
class RedirectStrategyOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testAssertDefaultValues()
    {
        $redirectStrategyOptions = new RedirectStrategyOptions();

        $this->assertTrue($redirectStrategyOptions->getRedirectWhenConnected());
        $this->assertEquals('login', $redirectStrategyOptions->getRedirectToRouteDisconnected());
        $this->assertEquals('home', $redirectStrategyOptions->getRedirectToRouteConnected());
        $this->assertTrue($redirectStrategyOptions->getSavePreviousUri());
        $this->assertEquals('redirectTo', $redirectStrategyOptions->getPreviousUriSessionKey());
    }

    public function testSettersAndGetters()
    {
        $redirectStrategyOptions = new RedirectStrategyOptions([
            'redirect_when_connected'        => false,
            'redirect_to_route_connected'    => 'foo',
            'redirect_to_route_disconnected' => 'bar',
            'save_previous_uri'              => false,
            'previous_uri_session_key'       => 'redirect-to'
        ]);

        $this->assertFalse($redirectStrategyOptions->getRedirectWhenConnected());
        $this->assertEquals('foo', $redirectStrategyOptions->getRedirectToRouteConnected());
        $this->assertEquals('bar', $redirectStrategyOptions->getRedirectToRouteDisconnected());
        $this->assertFalse($redirectStrategyOptions->getSavePreviousUri());
        $this->assertEquals('redirect-to', $redirectStrategyOptions->getPreviousUriSessionKey());
    }
}
