<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h5>{{$leaveType->getName()}} Application</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="callout callout-info py-2 mb-4">
                <p>
                    Your allowed period of {{$leaveType->getName()}} is {{$daysAllowed}} {{$leaveType->getUnit()}}. <br/>
                    Please make sure you cross-check your application before submission.
                </p>
            </div>

            <form>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">How many {{$leaveType->getUnit()}} do you want to apply
                            for? </label>
                        <input type="number" wire:model.lazy="leave.period"
                               class="form-control @error('leave.period') is-invalid @enderror"
                               placeholder="Enter Number of {{$leaveType->getUnit()}}"/>
                        @error('leave.period')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p style="font-style: italic; font-size: 14px">Should not be more than {{$daysAllowed}} {{$leaveType->getUnit()}}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">When do you want to start your {{$leaveType->getName()}}? </label>
                        <input type="date" wire:model.lazy="leave.start_date"
                               class="form-control @error('leave.start_date') is-invalid @enderror"
                               placeholder="Enter Leave Date"/>
                        @error('leave.start_date')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p style="font-style: italic; font-size: 14px">Supported date format: YYYY-MM-DD</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Who will handle matters on your behalf? </label>
                        <input type="text" wire:model.lazy="leave.delegation"
                               class="form-control @error('leave.delegation') is-invalid @enderror"
                               placeholder="Enter One or More Names"/>
                        @error('leave.delegation')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p style="font-style: italic; font-size: 14px">Separate names with commas</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Please provide a brief summary for your leave (optional). </label>
                        <textarea wire:model.lazy="leave.summary"
                                  class="form-control @error('leave.summary') is-invalid @enderror"></textarea>
                        @error('leave.summary')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p style="font-style: italic; font-size: 14px">Should not be more than 150 words</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Please upload any supporting document (optional). </label>
                        <input type="file" wire:model.lazy="document"
                               class="form-control @error('document') is-invalid @enderror"/>
                        @error('document')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <p style="font-style: italic; font-size: 14px">Supported file formats: PDF, DOCX, PNG, JPG</p>
                    </div>

                    <div class="form-group">
                        <div class="float-left">
                            <button type="button" wire:click="saveDraft" class="btn btn-outline-primary">Save Draft
                            </button>
                        </div>
                        <div class="float-right">
                            <button type="button" wire:click="saveFinal" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
