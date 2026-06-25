<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Images\Handlers\GDHandler;
use CodeIgniter\Images\Handlers\ImageMagickHandler;

class Images extends BaseConfig
{
	/**
	 * Default handler used if no other handler is specified.
	 *
	 * @var string
	 */
	public $defaultHandler = 'gd';

	/**
	 * The path to the image library.
	 * Required for ImageMagick, GraphicsMagick, or NetPBM.
	 *
	 * @var string
	 */
	public $libraryPath = '/usr/local/bin/convert';

	/**
	 * The available handler classes.
	 *
	 * @var array<string, string>
	 */
	public $handlers = [
		'gd'      => GDHandler::class,
		'imagick' => ImageMagickHandler::class,
	];
}
 in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
