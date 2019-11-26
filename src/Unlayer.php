<?php declare(strict_types=1);

namespace IDF\NovaUnlayerField;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Http\Requests\NovaRequest;

final class Unlayer extends Code
{
    /**
     * The field's component.
     * @var string
     */
    public $component = 'nova-unlayer-field';

    /**
     * Indicates if the field is used to manipulate JSON.
     * @var bool
     */
    public $json = true;

    /** @var callable|null */
    public $savingCallback;

    /**
     * Indicates if the element should be shown on the index view.
     * @var bool
     */
    public $showOnDetail = false;

    /**
     * Specify Unlayer config
     * @see https://docs.unlayer.com/docs/getting-started#section-configuration-options
     * @param array|callable $config
     * @return \IDF\NovaUnlayerField\Unlayer
     */
    public function config($config): Unlayer
    {
        $unlayerConfig = is_callable($config)
            ? $config()
            : $config;

        return $this->withMeta(['config' => $unlayerConfig]);
    }

    public function savingCallback(?callable $callback): Unlayer
    {
        $this->savingCallback = $callback;

        return $this;
    }

    /**
     * Set height of the editor (with units)
     * @param string $height E.g. "800px"
     * @return \IDF\NovaUnlayerField\Unlayer
     */
    public function height(string $height): Unlayer
    {
        return $this->withMeta(['height' => $height]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param string $requestAttribute
     * @param Model $model
     * @param string $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($this->savingCallback) {
            call_user_func($this->savingCallback, $request, $request, $model, "{$requestAttribute}_html");
        }

        if ($request->exists($requestAttribute)) {
            $model->setAttribute($attribute, $request->get($requestAttribute));
        }
    }
}
